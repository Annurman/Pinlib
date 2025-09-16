<!-- resources/views/members/create.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
</head>
<body>
    <h1>Tambah Anggota</h1>
    <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <label>Nama:</label>
        <input type="text" name="name" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Telepon:</label>
        <input type="text" name="phone" required>
        <br>
        <label>Alamat:</label>
        <input type="text" name="address" required>
        <br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
