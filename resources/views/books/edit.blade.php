<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
</head>
<body>
    <h1>Edit Buku</h1>

    <form action="{{ route('books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Judul:</label> <input type="text" name="title" value="{{ $book->title }}" required><br>
        <label>Penulis:</label> <input type="text" name="author" value="{{ $book->author }}" required><br>
        <label>Penerbit:</label> <input type="text" name="publisher" value="{{ $book->publisher }}" required><br>
        <label>Tahun:</label> <input type="number" name="year" value="{{ $book->year }}" required><br>
        <label>ISBN:</label> <input type="text" name="isbn" value="{{ $book->isbn }}" required><br>
        <label>Stok:</label> <input type="number" name="stock" value="{{ $book->stock }}" required><br>
        <button type="submit">Update</button>
    </form>

    <a href="{{ route('books.index') }}">Kembali</a>
</body>
</html>
