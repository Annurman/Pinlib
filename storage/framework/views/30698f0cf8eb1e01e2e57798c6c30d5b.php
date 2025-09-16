

<?php $__env->startSection('content'); ?>

<div class="pt-24 px-4 animate-fade-in">
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        
        
        <div class="bg-blue-600 text-white px-6 py-4 text-center">
            <h2 class="text-xl font-semibold tracking-wide">Bukti Peminjaman</h2>
            <p class="text-sm opacity-90">Perpustakaan Pinlib</p>
        </div>

        
        
        <div class="px-6 py-5 space-y-4 text-gray-800 text-sm">
        <div class="flex justify-between items-center border-b pb-2">
       
    </div>
            <div class="flex justify-between items-center border-b pb-2">
                <span class="font-medium flex items-center gap-1">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Judul Buku
                </span>
                <span class="text-right"><?php echo e($borrowing->book->title ?? 'Tidak ditemukan'); ?></span>
            </div>
            <div class="flex justify-between items-center border-b pb-2">
                <span class="font-medium flex items-center gap-1">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 10h11M9 21V3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    ISBN
                </span>
                <span class="text-right"><?php echo e($borrowing->book->isbn ?? '-'); ?></span>
            </div>
            <div class="flex justify-between items-center border-b pb-2">
                <span class="font-medium flex items-center gap-1">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 9h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Dipinjam Pada
                </span>
                <span class="text-right"><?php echo e($borrowing->borrowed_at->format('d M Y')); ?></span>
            </div>
            <div class="flex justify-between items-center border-b pb-2">
                <span class="font-medium flex items-center gap-1">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 9h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Jatuh Tempo
                </span>
                <span class="text-right"><?php echo e($borrowing->due_date->format('d M Y')); ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-medium flex items-center gap-1">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4M12 22a10 10 0 110-20 10 10 0 010 20z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Status
                </span>
                <span class="text-xs px-2 py-1 rounded-full font-semibold
                    <?php echo e($borrowing->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       ($borrowing->status === 'returned' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800')); ?>">
                    <?php echo e(ucfirst($borrowing->status)); ?>

                </span>
            </div>

           
        </div>

        
        <div class="px-6 py-4 border-t bg-gray-50 text-center">
            <a href="<?php echo e(route('users.dashboard')); ?>" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-700 transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/users/borrowings/show.blade.php ENDPATH**/ ?>