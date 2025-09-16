@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Daftar Anggota</h2>

    <form action="{{ route('members.index') }}" method="GET" class="flex flex-wrap gap-4 items-center justify-end mb-6">
        <select name="filter_by" class="border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400">
            <option value="name" {{ request('filter_by') == 'name' ? 'selected' : '' }}>Nama</option>
            <option value="member_number" {{ request('filter_by') == 'member_number' ? 'selected' : '' }}>Nomor Anggota</option>
            <option value="registered_at" {{ request('filter_by') == 'registered_at' ? 'selected' : '' }}>Tanggal Daftar</option>
        </select>

        <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}"
            class="w-48 border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400">

        <select name="status" class="border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
            Cari
        </button>
    </form>

    @if(request('search') || request('status'))
        <p class="text-sm text-gray-500 mb-4">
            Menampilkan hasil 
            @if(request('search'))
                untuk <strong>{{ request('search') }}</strong> berdasarkan <strong>{{ ucfirst(str_replace('_', ' ', request('filter_by'))) }}</strong>
            @endif
            @if(request('status'))
                dengan status <strong>{{ ucfirst(request('status')) }}</strong>
            @endif
        </p>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gradient-to-r from-[#96B8F2] to-[#F5F7FA] text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">User ID</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Telepon</th>
                    <th class="px-4 py-3">No Anggota</th>
                    <th class="px-4 py-3">Tanggal Daftar</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $member->user_id }}</td>
                    <td class="px-4 py-2">{{ $member->name }}</td>
                    <td class="px-4 py-2">{{ $member->no_hp }}</td>
                    <td class="px-4 py-2">{{ $member->member_number }}</td>
                    <td class="px-4 py-2">{{ $member->registered_at->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                            @if($member->membership_status === 'approved') bg-green-100 text-green-700
                            @elseif($member->membership_status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-600
                            @endif">
                            {{ ucfirst($member->membership_status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex flex-wrap gap-2 justify-center">
                        @if($member->membership_status === 'pending')
                        <form action="{{ route('admin.members.approve', $member->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">
                                Approve
                            </button>
                        </form>
                        @endif

                        <button class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-xs edit-btn"
                            data-id="{{ $member->user_id }}"
                            data-name="{{ $member->name }}"
                            data-phone="{{ $member->no_hp }}"
                            data-address="{{ $member->member_number }}">
                            Edit
                        </button>

                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $members->links() }}
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMemberForm">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-phone" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="edit-phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-address" class="form-label">Member_Number</label>
                        <input type="text" class="form-control" id="edit-address" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Isi data ke modal
    $(".edit-btn").click(function () {
        $("#edit-id").val($(this).data("id"));
        $("#edit-name").val($(this).data("name"));
        $("#edit-email").val($(this).data("email"));
        $("#edit-phone").val($(this).data("phone"));
        $("#edit-address").val($(this).data("address"));
        $("#editMemberModal").modal("show");
    });

    // Submit form edit
    $("#editMemberForm").submit(function (e) {
        e.preventDefault();

        let id = $("#edit-id").val();
        let name = $("#edit-name").val();
        let email = $("#edit-email").val();
        let phone = $("#edit-phone").val();
        let address = $("#edit-address").val();
        let _token = $("input[name=_token]").val();

        $.ajax({
            url: "/admin/members/" + id,
            type: "PUT",
            data: {
                _token: _token,
                name: name,
                email: email,
                phone: phone,
                address: address
            },
            success: function (response) {
                alert("Data berhasil diperbarui!");
                location.reload();
            },
            error: function (xhr) {
                alert("Terjadi kesalahan saat memperbarui data.");
                console.log(xhr.responseText);
            }
        });
    });
});
</script>
@endsection
