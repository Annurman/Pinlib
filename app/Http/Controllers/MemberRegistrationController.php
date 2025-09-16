<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\Admin;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMemberRegistered;
use Illuminate\Http\Request;
use App\Notifications\NewMemberNotification;
use Illuminate\Support\Facades\Notification;

class MemberRegistrationController extends Controller
{

    public function index()
    { $user = Auth::user();
        $profile = $user->profile; // pastikan relasi profile sudah dibuat
        $members = Member::with('library.profile')
        ->where('user_id', $user->id)
        ->get();
        $libraries = Admin::with('profile')->get(); // ambil daftar perpustakaan

       
        return view('users.anggota', compact('user', 'profile', 'libraries', 'members'));
   }
   public function create()
{
    $user = Auth::user();
    $profile = $user->profile;
     $members = Member::with('library.profile')
        ->where('user_id', $user->id)
        ->get();
    $libraries = Admin::with('profile')->get();

    return view('users.anggota-daftar', compact('user', 'profile', 'libraries', 'members'));
}

public function store(Request $request)
{
    $request->validate([
        'library_id' => 'required|exists:admins,id',
    ]);
    

    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Harap login terlebih dahulu.');
    }

    $user = Auth::user();
    $profile = $user->profile;
    $members = Member::with('library.profile')
    ->where('user_id', $user->id)
    ->get();

    // Cegah duplikat pendaftaran
    // Cegah duplikat pendaftaran ke perpustakaan tertentu
if (Member::where('user_id', $user->id)->where('library_id', $request->library_id)->exists()) {
    return redirect()->back()->withInput()->withErrors([
        'library_id' => 'Kamu sudah mendaftar ke perpustakaan ini.'
    ]);
}


    // Buat nomor anggota unik
    $today = now()->format('Ymd');
    $last = Member::whereDate('created_at', now())->count() + 1;
    $memberNumber = 'P-' . $today . '-' . str_pad($last, 3, '0', STR_PAD_LEFT);

    // ✅ GUNAKAN DARI REQUEST
    $member = Member::create([
        'user_id' => $user->id,
        'library_id' => $request->library_id,
        'name' => $user->name,
        'no_hp' => $profile->no_hp,
        'profile_image' => $request->profile_image ?? 'default.png', // ✅ INI YANG BENAR
        'member_number' => $memberNumber,
        'membership_status' => 'pending',
        'registered_at' => now(),
    ]);

    
$admins = Admin::all();
Notification::send($admins, new NewMemberNotification($member));


    return redirect()->route('member.index')->with('success', 'Pendaftaran anggota berhasil!');
}

  

 
   public function showCard($id)
{
    $member = Member::with(['library.profile', 'user.profile'])->findOrFail($id);
    $profile = $member->user->profile;
    // Opsional: Cek apakah yang akses adalah pemiliknya
    if ($member->user_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    return view('users.card', compact('member', 'profile'));
}


}
