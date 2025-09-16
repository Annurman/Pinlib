@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-8 mt-24 animate-fade-in">
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="{{ route('member.index') }}" 
           class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 
                  rounded-full px-4 py-2 shadow transition duration-300 text-sm font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Judul -->
    <h2 class="text-3xl font-bold mb-6 text-center text-blue-800">Daftar ke Perpustakaan Baru</h2>

    <!-- Form -->
    <form action="{{ route('daftar.store') }}" method="POST" 
          class="bg-white p-8 rounded-2xl shadow-2xl max-w-xl mx-auto space-y-6 border border-blue-100">
        @csrf

        <!-- Info Diri -->
        <div class="flex items-center gap-4">
            <img src="{{ $profile && $profile->profile_image 
                ? asset('storage/' . $profile->profile_image) 
                : asset('images/user-placeholder.png') }}"
                class="w-12 h-12 rounded-full object-cover border-2 border-blue-500 shadow-sm"
                alt="Foto Profil">
            <div>
                <input type="hidden" name="profile_image" value="{{ $profile->profile_image }}">
                <p class="font-semibold text-gray-800">Nama: {{ $user->name }}</p>
                <p class="text-sm text-gray-500">No HP: {{ $profile->no_hp ?? '-' }}</p>
            </div>
        </div>

         <!-- Pilih Perpustakaan -->
    <div>
        <label class="block font-semibold text-gray-700 mb-1">Pilih Perpustakaan</label>
        <div class="relative">
            <i data-lucide="library" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
            <select name="library_id" required
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">-- Pilih Perpustakaan --</option>
                @foreach($libraries as $lib)
                    <option value="{{ $lib->id }}" 
                        {{ old('library_id') == $lib->id ? 'selected' : '' }}>
                        {{ $lib->profile->library_name ?? $lib->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Menampilkan pesan error jika ada -->
        @error('library_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>


        <!-- Tombol Submit -->
        <div class="text-center">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                           text-white px-6 py-3 rounded-full font-medium shadow-lg transition-all duration-300">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>Daftar Sekarang</span>
            </button>
        </div>
    </form>
</div>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
