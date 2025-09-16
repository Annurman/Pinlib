<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Tampilkan halaman login admin
    public function create()
    {
        return view('admin.login');
    }
        
    public function index()
    {

    $members = Member::with('user')->latest()->get(); // atau paginate()
    $admin = auth('admin')->user();

    // Ambil data notifikasi pendaftaran member yang masuk ke perpustakaan admin ini
    $memberNotifs = Member::with('user')
        ->where('library_id', $admin->id)
        ->latest()
        ->take(10)
        ->get();

        $now = Carbon::now();
    $startOfWeek = $now->startOfWeek();
    $endOfWeek = $now->copy()->endOfWeek();

    $borrowingsThisWeek = Borrowing::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
    $returnsThisWeek = Borrowing::whereBetween('returned_at', [$startOfWeek, $endOfWeek])->whereNotNull('returned_at')->count();
    $totalBooks = Book::count();
    $totalMembers = Member::count();

    return view('dashboard', compact('members'), [
        'memberNotifs' => $memberNotifs,
        'borrowingsThisWeek' => $borrowingsThisWeek,
        'returnsThisWeek' => $returnsThisWeek,
        'totalBooks' => Book::count(),
        'totalMembers' => Member::count(),
    ]);
    }

    // Proses login admin
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard'); // Redirect ke dashboard admin
        }
    
        return back()->withErrors(['email' => 'Email atau password salah']);
    }
    
    
    

    // Proses logout admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('users.dashboard');
    }
}
