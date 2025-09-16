<!-- Modal Edit Profil (Tailwind + Alpine.js) -->
<div x-data="{ openModal: false }">
    <!-- Tombol untuk membuka modal -->
   

    <!-- Overlay Modal -->
    <div x-show="openModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center transition-opacity"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Konten Modal -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="scale-90 opacity-0"
             x-transition:enter-end="scale-100 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="scale-100 opacity-100"
             x-transition:leave-end="scale-90 opacity-0">
            
            <!-- Tombol Close -->
            <button @click="openModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                ❌
            </button>

            <h2 class="text-xl font-semibold mb-4 text-center">Edit Profil</h2>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <label class="block mb-2 text-sm">Nama:</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full p-2 border rounded">

                <label class="block mt-3 mb-2 text-sm">No HP:</label>
                <input type="text" name="no_hp" value="{{ $profile->no_hp ?? '' }}" class="w-full p-2 border rounded">

                <label class="block mt-3 mb-2 text-sm">Tanggal Lahir:</label>
                <input type="date" name="tgl_lahir" value="{{ $profile->tgl_lahir ?? '' }}" class="w-full p-2 border rounded">

                <label class="block mt-3 mb-2 text-sm">Alamat:</label>
                <textarea name="alamat" class="w-full p-2 border rounded">{{ $profile->alamat ?? '' }}</textarea>

                <div class="flex justify-end mt-4">
                    <button type="button" @click="openModal = false" class="mr-2 bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
