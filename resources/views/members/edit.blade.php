@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">✏️ Edit Anggota</h4>
        </div>


        <div class="card-body">
            <form action="{{ route('members.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $member->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ $member->phone }}" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" required>{{ $member->address }}</textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    💾 Simpan Perubahan
                </button>
                
            </form>
        </div>
    </div>
</div>
@endsection
