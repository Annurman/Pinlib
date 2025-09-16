<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    
     public function index(Request $request)
     {
         $search = $request->input('search');
         $filterBy = $request->input('filter_by');
         $statusFilter = $request->input('status');
     
         $borrowingsBase = Borrowing::with(['member.user', 'book'])
             ->when($search && $filterBy, function ($query) use ($search, $filterBy) {
                 $query->where(function ($q) use ($search, $filterBy) {
                     if ($filterBy === 'name') {
                         $q->whereHas('member.user', function ($q2) use ($search) {
                             $q2->where('name', 'like', '%' . $search . '%');
                         });
                     } elseif ($filterBy === 'title') {
                         $q->whereHas('book', function ($q2) use ($search) {
                             $q2->where('title', 'like', '%' . $search . '%');
                         });
                     } elseif ($filterBy === 'borrowed_at') {
                         $q->whereDate('borrowed_at', $search);
                     }
                 });
             });
     
         $borrowings = (clone $borrowingsBase)
             ->when($statusFilter, function ($query, $status) {
                 $query->where('status', $status);
             }, function ($query) {
                 $query->whereIn('status', ['borrowed', 'return_requested']);
             })
             ->paginate(10, ['*'], 'borrowings');
     
         $returns = (clone $borrowingsBase)
             ->where('status', 'returned')
             ->paginate(10, ['*'], 'returns');
     
         $lostBooks = (clone $borrowingsBase)
             ->where('status', 'lost')
             ->paginate(10, ['*'], 'lostBooks');
     
         return view('borrowings.index', compact('borrowings', 'returns', 'lostBooks', 'search', 'statusFilter', 'filterBy'));
     }
     
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $books = Book::all();
        return view('borrowings.create', compact('users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after:borrowed_at',
        ]);

        Borrowing::create($request->all());
        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        $users = User::all();
        $books = Book::all();
        return view('borrowings.edit', compact('borrowing', 'users', 'books'));
   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after:borrowed_at',
            'returned_at' => 'nullable|date|after:borrowed_at',
        ]);

        $borrowing->update($request->all());
        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dihapus.');
    
    }

    public function returnBook($id)
{
    $borrowing = Borrowing::findOrFail($id);
    $borrowing->returned_at = now(); // Simpan waktu pengembalian
    $borrowing->save();

    return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
}

public function markAsFound(Borrowing $borrowing)
{
    if (!$borrowing->is_lost) {
        return back()->with('error', 'Buku ini tidak dalam status hilang.');
    }

    $borrowing->is_lost = false;
    $borrowing->status = 'borrowed'; // atau status lain jika kamu mau
    $borrowing->save();

    return back()->with('success', 'Status buku berhasil diperbarui: tidak hilang.');
}
 

}
