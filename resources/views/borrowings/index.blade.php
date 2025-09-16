@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Data Peminjaman & Pengembalian</h2>

    <div class="row">
        <!-- Filter dan Search -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
    <div>
        <label for="filter_by" class="block text-sm font-medium text-gray-700">🔎 Cari Berdasarkan</label>
        <select name="filter_by" id="filter_by"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <option value="name" {{ request('filter_by') == 'name' ? 'selected' : '' }}>Nama Peminjam</option>
            <option value="title" {{ request('filter_by') == 'title' ? 'selected' : '' }}>Judul Buku</option>
            <option value="borrowed_at" {{ request('filter_by') == 'borrowed_at' ? 'selected' : '' }}>Tanggal Pinjam</option>
        </select>
    </div>

    <div>
        <label for="search" class="block text-sm font-medium text-gray-700">🔍 Kata Kunci</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
               placeholder="Masukkan kata kunci...">
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">📌 Status</label>
        <select name="status" id="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <option value="">Semua</option>
            <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
            <option value="return_requested" {{ request('status') == 'return_requested' ? 'selected' : '' }}>Menunggu Pengembalian</option>
        </select>
    </div>

    <div>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 mt-1 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Cari
        </button>
    </div>
</form>


                
        </div>

        <!-- Table Peminjaman -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📖 Peminjaman Buku</h5>
                </div>
                <div class="card-body">

                    {{-- 📚 Daftar Peminjaman Aktif --}}
                    <h6 class="fw-bold mb-3">📚 Daftar Peminjaman Aktif</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Peminjam</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($borrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->member?->name ?? 'Tidak Diketahui' }}</td>
                                        <td>{{ $borrowing->book->title }}</td>
                                        <td>{{ $borrowing->borrowed_at }}</td>
                                        <td>{{ $borrowing->due_date }}</td>
                                        <td>
                                            @if($borrowing->status === 'return_requested')
                                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                            @elseif($borrowing->status === 'borrowed')
                                                <span class="badge bg-info text-dark">Dipinjam</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($borrowing->status === 'return_requested')
                                                <form action="{{ route('borrowings.approveReturn', $borrowing->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-success btn-sm" onclick="return confirm('Setujui pengembalian buku ini?')">Approve</button>
                                                </form>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada data peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $borrowings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Pengembalian -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">✅ Pengembalian Buku Selesai</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Peminjam</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Tanggal Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($returns as $return)
                                    <tr>
                                        <td>{{ $return->member?->name ?? 'Tidak diketahui' }}</td>
                                        <td>{{ $return->book->title }}</td>
                                        <td>{{ $return->borrowed_at }}</td>
                                        <td>{{ $return->due_date }}</td>
                                        <td>{{ $return->returned_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada buku yang dikembalikan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $returns->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Buku Hilang -->
        <div class="col-12 mt-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">❗ Buku Dilaporkan Hilang</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Peminjam</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lostBooks as $lost)
                                    <tr>
                                        <td>{{ $lost->member?->name ?? '-' }}</td>
                                        <td>{{ $lost->book->title }}</td>
                                        <td>{{ $lost->borrowed_at }}</td>
                                        <td>{{ $lost->due_date }}</td>
                                        <td>
                                            <span class="badge bg-danger">Hilang</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('borrowings.mark.found', $lost->id) }}" method="POST" onsubmit="return confirm('Yakin ingin tandai buku ini sudah ditemukan?')">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-outline-success btn-sm">Tandai Ditemukan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada laporan buku hilang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $lostBooks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
