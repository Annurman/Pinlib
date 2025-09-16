

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Data Peminjaman & Pengembalian</h2>

    <div class="row">
        <!-- Filter dan Search -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
    <div>
        <label for="filter_by" class="block text-sm font-medium text-gray-700">🔎 Cari Berdasarkan</label>
        <select name="filter_by" id="filter_by"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <option value="name" <?php echo e(request('filter_by') == 'name' ? 'selected' : ''); ?>>Nama Peminjam</option>
            <option value="title" <?php echo e(request('filter_by') == 'title' ? 'selected' : ''); ?>>Judul Buku</option>
            <option value="borrowed_at" <?php echo e(request('filter_by') == 'borrowed_at' ? 'selected' : ''); ?>>Tanggal Pinjam</option>
        </select>
    </div>

    <div>
        <label for="search" class="block text-sm font-medium text-gray-700">🔍 Kata Kunci</label>
        <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
               placeholder="Masukkan kata kunci...">
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">📌 Status</label>
        <select name="status" id="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            <option value="">Semua</option>
            <option value="borrowed" <?php echo e(request('status') == 'borrowed' ? 'selected' : ''); ?>>Dipinjam</option>
            <option value="return_requested" <?php echo e(request('status') == 'return_requested' ? 'selected' : ''); ?>>Menunggu Pengembalian</option>
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
                                <?php $__empty_1 = true; $__currentLoopData = $borrowings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrowing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($borrowing->member?->name ?? 'Tidak Diketahui'); ?></td>
                                        <td><?php echo e($borrowing->book->title); ?></td>
                                        <td><?php echo e($borrowing->borrowed_at); ?></td>
                                        <td><?php echo e($borrowing->due_date); ?></td>
                                        <td>
                                            <?php if($borrowing->status === 'return_requested'): ?>
                                                <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                            <?php elseif($borrowing->status === 'borrowed'): ?>
                                                <span class="badge bg-info text-dark">Dipinjam</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($borrowing->status === 'return_requested'): ?>
                                                <form action="<?php echo e(route('borrowings.approveReturn', $borrowing->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button class="btn btn-success btn-sm" onclick="return confirm('Setujui pengembalian buku ini?')">Approve</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada data peminjaman.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <?php echo e($borrowings->links()); ?>

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
                                <?php $__empty_1 = true; $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($return->member?->name ?? 'Tidak diketahui'); ?></td>
                                        <td><?php echo e($return->book->title); ?></td>
                                        <td><?php echo e($return->borrowed_at); ?></td>
                                        <td><?php echo e($return->due_date); ?></td>
                                        <td><?php echo e($return->returned_at); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada buku yang dikembalikan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <?php echo e($returns->links()); ?>

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
                                <?php $__empty_1 = true; $__currentLoopData = $lostBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($lost->member?->name ?? '-'); ?></td>
                                        <td><?php echo e($lost->book->title); ?></td>
                                        <td><?php echo e($lost->borrowed_at); ?></td>
                                        <td><?php echo e($lost->due_date); ?></td>
                                        <td>
                                            <span class="badge bg-danger">Hilang</span>
                                        </td>
                                        <td>
                                            <form action="<?php echo e(route('borrowings.mark.found', $lost->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin tandai buku ini sudah ditemukan?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button class="btn btn-outline-success btn-sm">Tandai Ditemukan</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada laporan buku hilang.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <?php echo e($lostBooks->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/borrowings/index.blade.php ENDPATH**/ ?>