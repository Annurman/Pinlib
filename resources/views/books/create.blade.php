<!-- resources/views/books/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Buku Baru</h2>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" id="book-form">
        @csrf

        <!-- ISBN + Fetch -->
        <div class="mb-4">
            <label for="isbn" class="block font-semibold">ISBN</label>
            <div class="flex gap-2">
                <input type="text" name="isbn" id="isbn" class="form-input w-full" placeholder="Contoh: 9786020324780">
                <button type="button" id="fetch-isbn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cek Info Buku
                </button>
            </div>
        </div>

        <!-- Judul -->
        <div class="mb-4">
            <label for="title" class="block font-semibold">Judul</label>
            <input type="text" name="title" id="title" class="form-input w-full">
        </div>

        <!-- Penulis -->
        <div class="mb-4">
            <label for="author" class="block font-semibold">Penulis</label>
            <input type="text" name="author" id="author" class="form-input w-full">
        </div>

        <!-- Penerbit -->
        <div class="mb-4">
            <label for="publisher" class="block font-semibold">Penerbit</label>
            <input type="text" name="publisher" id="publisher" class="form-input w-full">
        </div>

        <!-- Tahun Terbit -->
        <div class="mb-4">
            <label for="year" class="block font-semibold">Tahun Terbit</label>
            <input type="text" name="year" id="year" class="form-input w-full">
        </div>

        <!-- Eksemplar -->
        <div class="mb-4">
            <label for="stock" class="block font-semibold">Jumlah Eksemplar</label>
            <input type="number" name="stock" id="stock" class="form-input w-full" min="1">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Simpan Buku
        </button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('fetch-isbn').addEventListener('click', async () => {
    const isbn = document.getElementById('isbn').value.trim();
    if (!isbn) return alert('Masukkan ISBN terlebih dahulu!');

    try {
        const response = await axios.get(`https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}`);
        const book = response.data.items?.[0]?.volumeInfo;

        if (!book) return alert('Buku tidak ditemukan di Google Books');

        document.getElementById('title').value = book.title || '';
        document.getElementById('author').value = book.authors?.join(', ') || '';
        document.getElementById('publisher').value = book.publisher || '';
        document.getElementById('year').value = book.publishedDate?.slice(0, 4) || '';
        document.getElementById('description').value = book.description || '';

    } catch (err) {
        alert('Gagal mengambil data buku. Coba lagi.');
        console.error(err);
    }
});
</script>

@endsection
