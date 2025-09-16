
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Daftar Admin</h2>
    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" class="mt-1 p-2 w-full border rounded-md" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="mt-1 p-2 w-full border rounded-md" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" class="mt-1 p-2 w-full border rounded-md" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="mt-1 p-2 w-full border rounded-md" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Daftar</button>
    </form>
</div>

