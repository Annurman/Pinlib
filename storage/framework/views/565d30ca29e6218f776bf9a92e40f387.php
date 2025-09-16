

<?php $__env->startSection('content'); ?>
<div class="flex flex-col mt-20">
    <div class="container flex flex-col min-h-screen mt-3">

    <div class="mb-4">
        <a href="<?php echo e(route('users.dashboard')); ?>" 
           class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 hover:text-gray-900 
                  rounded-full p-3 shadow transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>
        <h1 class="mb-4 text-center">📚 Riwayat Peminjaman Buku</h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php if($borrowings->count() > 0): ?>
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
                        <?php $__currentLoopData = $borrowings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrowing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($borrowing->book->title); ?></td>
                                <td><?php echo e($borrowing->created_at->format('d M Y, H:i')); ?></td>
                                <td>
                                    <?php
                                        $statusColor = [
                                            'borrowed' => 'warning',
                                            'pending_return' => 'info',
                                            'returned' => 'success'
                                        ];
                                    ?>
                                    <span class="badge bg-<?php echo e($statusColor[$borrowing->status] ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $borrowing->status))); ?>

                                    </span>
                                    <?php if($borrowing->is_lost): ?>
                                        <span class="badge bg-danger">Hilang</span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-flex gap-2 flex-column">
                                    
                                    <?php if($borrowing->status === 'borrowed'): ?>
                                        <form action="<?php echo e(route('borrowings.return.request', $borrowing->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                🔁 Minta Pengembalian
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    
                                    <?php if($borrowing->status === 'borrowed' && !$borrowing->is_lost): ?>
                                        <form action="<?php echo e(route('borrowings.report.lost', $borrowing->id)); ?>" method="POST" onsubmit="return confirm('Yakin buku ini hilang?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                ❗ Laporkan Hilang
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if($borrowing->status !== 'borrowed' && !$borrowing->is_lost): ?>
                                        <em class="text-muted">-</em>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="text-center mr-5">
                    <a href="<?php echo e(route('users.borrowings.create')); ?>" class="btn btn-primary mt-3">
                        📘 Pinjam Buku 
                    </a>
                </div>

                <div class="mt-3">
                    <?php echo e($borrowings->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="text-center mt-5">
                <div style="font-size: 64px;">📭</div>
                <h4 class="mt-3">Belum Ada Peminjaman</h4>
                <p class="text-muted">Kamu belum pernah meminjam buku dari perpustakaan manapun.</p>
                <a href="<?php echo e(route('users.borrowings.create')); ?>" class="btn btn-primary mt-3">
                    📘 Pinjam Buku Sekarang
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/users/borrowings/index.blade.php ENDPATH**/ ?>