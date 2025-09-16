@extends('layouts.user')

@section('content')
<div class="flex flex-col mt-20">
    <div class="container flex flex-col min-h-screen mt-3">

    <div class="mb-4">
        <a href="{{ route('users.dashboard') }}" 
           class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 hover:text-gray-900 
                  rounded-full p-3 shadow transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>
        <h1 class="mb-4 text-center">📚 Riwayat Peminjaman Buku</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($borrowings->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($borrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->book->title }}</td>
                                <td>{{ $borrowing->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    @php
                                        $statusColor = [
                                            'borrowed' => 'warning',
                                            'pending_return' => 'info',
                                            'returned' => 'success'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColor[$borrowing->status] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $borrowing->status)) }}
                                    </span>
                                    @if ($borrowing->is_lost)
                                        <span class="badge bg-danger">Hilang</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2 flex-column">
                                    {{-- Tombol Minta Pengembalian --}}
                                    @if ($borrowing->status === 'borrowed')
                                        <form action="{{ route('borrowings.return.request', $borrowing->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                🔁 Minta Pengembalian
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Laporkan Hilang --}}
                                    @if ($borrowing->status === 'borrowed' && !$borrowing->is_lost)
                                        <form action="{{ route('borrowings.report.lost', $borrowing->id) }}" method="POST" onsubmit="return confirm('Yakin buku ini hilang?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                ❗ Laporkan Hilang
                                            </button>
                                        </form>
                                    @endif

                                    @if ($borrowing->status !== 'borrowed' && !$borrowing->is_lost)
                                        <em class="text-muted">-</em>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-center mr-5">
                    <a href="{{ route('users.borrowings.create') }}" class="btn btn-primary mt-3">
                        📘 Pinjam Buku 
                    </a>
                </div>

                <div class="mt-3">
                    {{ $borrowings->links() }}
                </div>
            </div>
        @else
            <div class="text-center mt-5">
                <div style="font-size: 64px;">📭</div>
                <h4 class="mt-3">Belum Ada Peminjaman</h4>
                <p class="text-muted">Kamu belum pernah meminjam buku dari perpustakaan manapun.</p>
                <a href="{{ route('users.borrowings.create') }}" class="btn btn-primary mt-3">
                    📘 Pinjam Buku Sekarang
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
