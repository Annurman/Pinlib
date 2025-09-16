<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminProfile; // Tambahkan ini
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk hapus foto lama


class AdminProfileController extends Controller
{
   
    public function index()
    {
        $admin = Auth::user()->load('adminProfile'); // Ambil data admin + relasi adminProfile
        return view('admin.profile', compact('admin'));
    
    }
    
    public function create()
    {
        return view('admin.register'); // Halaman register admin
    }

 
    public function edit()
{
    $admin = Auth::user();
    return view('admin.edit', compact('admin'));
}


public function update(Request $request)
    {
        // Ambil admin yang sedang login
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin tidak ditemukan.');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'library_name' => 'nullable|string|max:255',
            'library_address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:15',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update data di tabel `admins`
        $admin->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        // Cek apakah admin sudah punya profil, jika belum buat baru
        $adminProfile = AdminProfile::firstOrNew(['admin_id' => $admin->id]);

        $adminProfile->library_name = $request->library_name;
        $adminProfile->library_address = $request->library_address;
        $adminProfile->phone_number = $request->phone_number;

        if ($request->hasFile('profile_image')) {
            if ($adminProfile->profile_image) {
                Storage::delete($adminProfile->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_pictures', 'public');
            $adminProfile->update(['profile_image' => $path]);
        }

        $adminProfile->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }



}
