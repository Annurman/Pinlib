

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-10 mt-24 animate-fade-in">

    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="<?php echo e(route('member.index')); ?>" 
           class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 hover:text-gray-900 
                  rounded-full px-4 py-2 shadow transition duration-300 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="w-full max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden border border-gray-300">

        <!-- Header KTP-style (beda dari navbar) -->
        <div class="bg-blue-800 text-white px-6 py-3 flex justify-between items-center">
            <div>
                <h2 class="text-base font-semibold uppercase tracking-wider">Kartu Anggota Perpustakaan</h2>
                <p class="text-xs"><?php echo e($member->library->profile->library_name ?? $member->library->name); ?></p>
            </div>
            <img src="<?php echo e(asset('storage/profile_pictures/logo-pinlib.png')); ?>" alt="Logo Pinlib" class="h-8">
        </div>

        <!-- Body -->
        <div class="flex px-6 py-6 bg-white gap-5">
            <!-- Foto -->
            <div class="w-1/4 flex justify-center items-start">
                <img src="<?php echo e($profile && $profile->profile_image 
                        ? asset('storage/' . $profile->profile_image) 
                        : asset('images/user-placeholder.png')); ?>"
                    class="w-24 h-32 rounded-md border border-blue-500 object-cover shadow"
                    alt="Foto Profil">
            </div>

            <!-- Data -->
            <div class="w-3/4 text-gray-800 text-sm space-y-1">
                <div class="flex">
                    <div class="w-36 font-medium">Nama Lengkap</div>
                    <div>: <?php echo e($member->name); ?></div>
                </div>
                <div class="flex">
                    <div class="w-36 font-medium">No. Anggota</div>
                    <div>: <?php echo e($member->member_number); ?></div>
                </div>
                <div class="flex">
                    <div class="w-36 font-medium">Email</div>
                    <div>: <?php echo e($member->user->email); ?></div>
                </div>
                <div class="flex">
                    <div class="w-36 font-medium">No HP</div>
                    <div>: <?php echo e($member->no_hp); ?></div>
                </div>
                <div class="flex">
                    <div class="w-36 font-medium">Status</div>
                    <div>: 
                        <span class="<?php echo e($member->membership_status === 'active' ? 'text-green-600 font-semibold' : 'text-yellow-600'); ?>">
                            <?php echo e(ucfirst($member->membership_status)); ?>

                        </span>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-36 font-medium">Terdaftar</div>
                    <div>: <?php echo e($member->registered_at->format('d M Y')); ?></div>
                </div>
            </div>
        </div>

        <!-- Footer strip -->
        <div class="h-1 bg-blue-600"></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/users/card.blade.php ENDPATH**/ ?>