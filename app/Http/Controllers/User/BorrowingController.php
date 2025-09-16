<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Events\BorrowingCreated;
use App\Events\ReturnRequested;
use App\Events\BookReturnApproved;

class BorrowingController extends Controller
{
    public function create()
    {
        // Ambil semua perpustakaan yang user sudah menjadi anggotanya
        $memberships = Member::with('library.profile')
    ->where('user_id', Auth::id())
    ->where('membership_status', 'approved')
    ->get();
        return view('users.borrowings.create', compact('memberships'));
    }

    public function index()
{
    $borrowings = Borrowing::with('book')
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

    return view('users.borrowings.index', compact('borrowings'));
}


    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'isbn' => 'required|string',
        ]);



        $member = Member::where('id', $request->member_id)
            ->where('user_id', Auth::id())
            ->where('membership_status', 'approved')
            
            ->firstOrFail();
            
if (!$member) {
    return back()->withErrors(['member_id' => 'Keanggotaan tidak ditemukan atau belum disetujui.']);
}

        // Cari buku berdasarkan ISBN dan perpustakaan anggota
        $book = Book::where('isbn', $request->isbn)
            ->where('admin_id', $member->library_id)
            ->first();
            

        if (!$book) {
            return back()->withErrors(['isbn' => 'Buku tidak ditemukan di perpustakaan tersebut.']);
        }

        if ($book->stock < 1) {
            return back()->withErrors(['isbn' => 'Stok buku habis.']);
        }


        // Kurangi stok
        $book->decrement('stock');

        $borrowing = Borrowing::create([

            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'member_id' => $member->id,
            'library_id' => $member->library_id, // tambahkan ini
            'borrowed_at' => now(),
            'due_date' => now()->addDays(7), // misal 7 hari
            'status' => 'borrowed',
        ]);

        event(new BorrowingCreated($borrowing));

        return redirect()->route('borrowings.show', $borrowing->id);
    }

    public function show($id)
    {
        $borrowing = Borrowing::with('book', 'library', 'member')->findOrFail($id);
        return view('users.borrowings.show', compact('borrowing'));
        

    }
    
    public function approveReturn(Borrowing $borrowing)
{
    $borrowing->status = 'returned'; // atau 'approved', sesuaikan dengan sistem kamu
    $borrowing->returned_at = now();
    $borrowing->book->increment('stock');
    $borrowing->save();

    return redirect()->back()->with('success', 'Pengembalian buku telah disetujui.');
}

public function reportLost(Borrowing $borrowing)
{
    // Validasi hanya bisa melaporkan yang statusnya masih dipinjam dan belum dilaporkan hilang
    if ($borrowing->status !== 'borrowed' || $borrowing->is_lost) {
        return back()->with('error', 'Buku ini tidak bisa dilaporkan hilang.');
    }

    $borrowing->is_lost = true;
    $borrowing->status = 'lost'; // jika kamu pakai status 'lost' juga
    $borrowing->save();

    return back()->with('success', 'Buku berhasil dilaporkan hilang.');
}





   


    public function requestReturn(Borrowing $borrowing)
{
    if ($borrowing->status !== 'borrowed') {
        return back()->with('error', 'Pengembalian tidak bisa diajukan.');
    }

    $borrowing->update([
        'status' => 'return_requested',
    ]);

    broadcast(new ReturnRequested($borrowing))->toOthers();

    return back()->with('success', 'Pengembalian berhasil diajukan.');
}
        

}

