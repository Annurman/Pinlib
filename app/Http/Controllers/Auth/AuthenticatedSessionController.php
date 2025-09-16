<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    
     public function create(): View
{
    return view('auth.login');
}

public function store(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('web')->attempt($credentials)) {
        return redirect()->route('users.dashboard'); // Redirect ke dashboard admin
    }

    return back()->withErrors(['email' => 'Email atau password salah']);
}



public function destroy(Request $request)
{
    Auth::guard('web')->logout(); // Logout untuk user biasa

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('users/dashboard'); // Redirect ke halaman login setelah logout
}

}
