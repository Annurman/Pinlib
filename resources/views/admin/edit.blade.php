@extends('layouts.app')

@section('content')
<h1>Admin Profile</h1>
<p>Nama: {{ Auth::user()->name }}</p>
<p>Email: {{ Auth::user()->email }}</p>
<p>Nama Perpustakaan: {{ optional($admin->adminProfile)->library_name ?? 'Belum diisi' }}</p>
<p>Alamat Perpustakaan: {{ optional($admin->adminProfile)->library_address ?? 'Belum diisi' }}</p>
<p>Telepon: {{ optional($admin->adminProfile)->phone_number ?? 'Belum diisi' }}</p>

@if(optional($admin->adminProfile)->profile_image)
    <img src="{{ url('storage/' . $admin->adminProfile->profile_image) }}" width="150">
@else
    <p>Belum ada foto</p>
@endif


<!-- Tombol untuk membuka modal edit profile -->
<button class="bg-indigo-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-indigo-600 transition duration-300" onclick="openModal()">
    Edit Profil
</button>

<!-- Modal Edit Profil -->
<div id="editProfileModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-semibold mb-4">Edit Profil</h2>
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="block font-medium">Nama:</label>
            <input type="text" name="name" value="{{ Auth::user()->name }}" required class="w-full border rounded p-2 mb-2">

            <label class="block font-medium">Email:</label>
            <input type="email" name="email" value="{{ Auth::user()->email }}" required class="w-full border rounded p-2 mb-2">

            <label class="block font-medium">Nama Perpustakaan:</label>
            <input type="text" name="library_name" value="{{ $admin->adminProfile->library_name ?? '' }}" class="w-full border rounded p-2 mb-2">

            <label class="block font-medium">Alamat Perpustakaan:</label>
            <textarea name="library_address" class="w-full border rounded p-2 mb-2">{{ $admin->adminProfile->library_address ?? '' }}</textarea>

            <label class="block font-medium">Telepon:</label>
            <input type="text" name="phone_number" value="{{ $admin->adminProfile->phone_number ?? '' }}" class="w-full border rounded p-2 mb-2">

            <label class="block font-medium">Foto Profil:</label>
            @if($admin->adminProfile->profile_image)
                <img src="{{ asset('storage/' . $admin->adminProfile->profile_image) }}" width="100" class="mb-2">
            @endif
            <input type="file" name="profile_image" class="w-full border rounded p-2 mb-2">

            <div class="flex justify-end space-x-2">
                <button type="button" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600" onclick="closeModal()">Batal</button>
                <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
</script>
@endsection
