@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Peminjaman</h2>
    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Peminjam</label>
            <select name="user_id" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Buku</label>
            <select name="book_id" class="form-control">
                @foreach ($books as $book)
                <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="borrowed_at" class="form-control">
        </div>
        <div class="mb-3">
            <label>Jatuh Tempo</label>
            <input type="date" name="due_date" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
