@extends('layouts.user')

@section('content')

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="flex flex-col min-h-screen mt-24 " x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }} }">
    <div class="container mx-auto px-4 relative">
        
        <!-- Tombol Kembali -->
        <a href="{{ route('users.dashboard') }}" 
           class="absolute top-1 left-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full p-3 shadow-md 
           transition duration-300 flex items-center justify-center w-12 h-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" 
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Profil Saya</h2>

         {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

        <div class="bg-white p-6 shadow-xl rounded-xl max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                
               <!-- Foto Profil -->
<div class="text-center">
    @if(optional($profile)->profile_image)
        <img src="{{ asset('storage/' . $profile->profile_image) }}" 
             class="rounded-full w-40 h-40 object-cover border-4 border-[#A3B8BF] shadow" 
             alt="Foto Profil">
    @else
        <div class="rounded-full w-40 h-40 flex items-center justify-center 
                    border-4 border-[#A3B8BF] shadow bg-gray-100 text-gray-500">
            Foto Profil
        </div>
    @endif
</div>

                <!-- Info Profil -->
                <div class="md:col-span-2">
                    <table class="w-full text-left">
                        <tr class="border-b">
                            <th class="py-2 text-gray-500">Nama</th>
                            <td class="py-2 font-medium text-gray-800">{{ $user->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="py-2 text-gray-500">No HP</th>
                            <td class="py-2 font-medium text-gray-800">{{ $profile->no_hp ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="py-2 text-gray-500">Tanggal Lahir</th>
                            <td class="py-2 font-medium text-gray-800">{{ $profile->tgl_lahir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 text-gray-500">Alamat</th>
                            <td class="py-2 font-medium text-gray-800">{{ $profile->alamat ?? '-' }}</td>
                        </tr>
                    </table>

                    <!-- Tombol Edit -->
                    <button @click="openModal = true" 
                            class="mt-5 bg-[#A3B8BF] text-white px-4 py-2 rounded-lg shadow hover:bg-[#8aa0a7] transition">
                        Edit Profil
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Edit Profil -->
        <div x-show="openModal" 
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 p-4 z-50 transition-all">
            <div class="bg-white p-6 rounded-xl shadow-lg w-full max-h-[80vh] overflow-y-auto relative">

                <!-- Close Button -->
                <button @click="openModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-xl">
                    ❌
                </button>

                <h2 class="text-xl font-semibold mb-4 text-center">Edit Profil</h2>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                   <!-- Preview Foto -->
                <div class="text-center mb-4">
                    <img id="previewImage" src="{{ optional($profile)->profile_image ? asset('storage/' . $profile->profile_image) : asset('images/default.png') }}" 
                        class="w-28 h-28 rounded-full mx-auto border-4 border-[#A3B8BF] object-cover shadow">
                    <input type="file" name="profile_image" accept="image/*" class="mt-3 w-full p-2 border rounded" 
                        onchange="previewFile(event)">
                    @error('profile_image') 
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <label class="block text-sm font-medium mb-1">Nama:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                    class="w-full p-2 border rounded mb-3">
                @error('name') 
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror

                <label class="block text-sm font-medium mb-1">No HP:</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $profile->no_hp ?? '') }}" 
                    pattern="[0-9]+" 
                    inputmode="numeric" 
                    class="w-full p-2 border rounded mb-3" 
                    placeholder="Hanya angka">
                @error('no_hp') 
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror

                <label class="block text-sm font-medium mb-1">Tanggal Lahir:</label>
                <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $profile->tgl_lahir ?? '') }}" 
                    max="{{ now()->toDateString() }}" 
                    class="w-full p-2 border rounded mb-3">
                @error('tgl_lahir') 
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror

                <label class="block text-sm font-medium mb-1">Alamat:</label>
                <textarea name="alamat" class="w-full p-2 border rounded">{{ old('alamat', $profile->alamat ?? '') }}</textarea>
                @error('alamat') 
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror

                   <div class="flex justify-between mt-5 gap-2">
                        <button type="button" 
                                @click="openModal = false" 
                                class="bg-gray-300 px-4 py-2 rounded text-sm hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-[#A3B8BF] text-white px-4 py-2 rounded text-sm hover:bg-[#8aa0a7]">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function previewFile(event) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('previewImage').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
