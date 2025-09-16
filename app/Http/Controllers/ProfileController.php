<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserProfile;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);

        return view('users.profile', compact('user', 'profile'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);

        return view('users.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'no_hp' => 'nullable|numeric|digits_between:10,12',
        'tgl_lahir' => 'nullable|date|before:today',
        'alamat' => 'nullable|string|min:10',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    $user = Auth::user();
    $user->update([
        'name' => $request->name,
        'email' => $user->email, // biar ga kosong
    ]);

    $profile = UserProfile::updateOrCreate(
        ['user_id' => $user->id],
        [
            'no_hp' => $request->no_hp,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
        ]
    );

    if ($request->hasFile('profile_image')) {
        if ($profile->profile_image) {
            Storage::disk('public')->delete($profile->profile_image);
        }
        $path = $request->file('profile_image')->store('profile_pictures', 'public');
        $profile->update(['profile_image' => $path]);
    }

    return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
}


    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Hapus juga data profile + foto kalau ada
        if ($user->profile) {
            if ($user->profile->profile_image && Storage::disk('public')->exists($user->profile->profile_image)) {
                Storage::disk('public')->delete($user->profile->profile_image);
            }
            $user->profile->delete();
        }

        $user->delete();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}
