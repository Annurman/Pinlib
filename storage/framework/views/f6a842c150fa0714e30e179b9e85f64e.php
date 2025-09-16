

<?php $__env->startSection('content'); ?>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script> AOS.init(); </script>

<div class="container mx-auto px-4 py-10 mt-24 animate-fade-in" data-aos="fade-up">
    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="<?php echo e(route('users.dashboard')); ?>"
           class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-100 text-gray-600 hover:text-gray-900 
                  rounded-full px-5 py-2.5 shadow transition duration-300">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Judul -->
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8 tracking-tight">📚 Keanggotaan Perpustakaan</h2>

    <!-- Box Info Keanggotaan -->
    <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl p-6 mb-10 border border-gray-100" data-aos="fade-up">
        <h3 class="text-xl font-semibold mb-4 flex items-center gap-2 text-indigo-700"><i data-lucide="user" class="w-5 h-5"></i>Informasi Kamu</h3>
        <ul class="space-y-2 text-gray-700">
            <li><strong>👤 Nama:</strong> <?php echo e($user->name); ?></li>
            <li><strong>📧 Email:</strong> <?php echo e($user->email); ?></li>
            <li><strong>📱 No HP:</strong> <?php echo e($profile->no_hp ?? '-'); ?></li>
        </ul>
    </div>

    <!-- Daftar Perpustakaan -->
    <div class="bg-white/90 backdrop-blur shadow-xl rounded-2xl p-6 mb-10 border border-gray-100" data-aos="fade-up" data-aos-delay="100">
        <h3 class="text-xl font-semibold mb-4 flex items-center gap-2 text-indigo-700">
            <i data-lucide="library" class="w-5 h-5"></i> Perpustakaan Terdaftar
        </h3>

        <?php if($members->isEmpty()): ?>
            <p class="text-gray-500 text-center">🚫 Belum ada keanggotaan aktif. Yuk daftar!</p>
        <?php else: ?>
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm text-left border border-gray-100 shadow-sm">
                    <thead class="bg-indigo-50 text-indigo-700 uppercase">
                        <tr>
                            <th class="px-6 py-3">Perpustakaan</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4"><?php echo e($member->library->profile->library_name ?? $member->library->name); ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                    <?php echo e($member->membership_status === 'pending' 
                                        ? 'bg-yellow-100 text-yellow-700' 
                                        : 'bg-green-100 text-green-700'); ?>">
                                    <?php echo e(ucfirst($member->membership_status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if($member->membership_status !== 'pending'): ?>
                                    <a href="<?php echo e(route('member.card', $member->id)); ?>" 
                                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-4 py-2 rounded-lg transition">
                                       🎫 Lihat Kartu
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">Menunggu Konfirmasi</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
         <!-- Tombol Daftar -->
<div class="text-center mt-10" data-aos="fade-up" data-aos-delay="200">
    <a href="<?php echo e(route('daftar.form')); ?>" 
       class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 
              text-white px-6 py-3 rounded-full shadow-lg transition-all duration-300 font-semibold tracking-wide">
        <i data-lucide="plus-circle" class="w-5 h-5"></i>
        <span>Daftar ke Perpustakaan Lain</span>
    </a>
</div>
    </div>

  

    </div>
</div>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script> lucide.createIcons(); </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/users/anggota.blade.php ENDPATH**/ ?>