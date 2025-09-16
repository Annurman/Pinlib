

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 mt-24 animate-fade-in">
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="<?php echo e(route('member.index')); ?>" 
           class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 
                  rounded-full px-4 py-2 shadow transition duration-300 text-sm font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Judul -->
    <h2 class="text-3xl font-bold mb-6 text-center text-blue-800">Daftar ke Perpustakaan Baru</h2>

    <!-- Form -->
    <form action="<?php echo e(route('daftar.store')); ?>" method="POST" 
          class="bg-white p-8 rounded-2xl shadow-2xl max-w-xl mx-auto space-y-6 border border-blue-100">
        <?php echo csrf_field(); ?>

        <!-- Info Diri -->
        <div class="flex items-center gap-4">
            <img src="<?php echo e($profile && $profile->profile_image 
                ? asset('storage/' . $profile->profile_image) 
                : asset('images/user-placeholder.png')); ?>"
                class="w-12 h-12 rounded-full object-cover border-2 border-blue-500 shadow-sm"
                alt="Foto Profil">
            <div>
                <input type="hidden" name="profile_image" value="<?php echo e($profile->profile_image); ?>">
                <p class="font-semibold text-gray-800">Nama: <?php echo e($user->name); ?></p>
                <p class="text-sm text-gray-500">No HP: <?php echo e($profile->no_hp ?? '-'); ?></p>
            </div>
        </div>

         <!-- Pilih Perpustakaan -->
    <div>
        <label class="block font-semibold text-gray-700 mb-1">Pilih Perpustakaan</label>
        <div class="relative">
            <i data-lucide="library" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
            <select name="library_id" required
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">-- Pilih Perpustakaan --</option>
                <?php $__currentLoopData = $libraries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lib): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lib->id); ?>" 
                        <?php echo e(old('library_id') == $lib->id ? 'selected' : ''); ?>>
                        <?php echo e($lib->profile->library_name ?? $lib->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <!-- Menampilkan pesan error jika ada -->
        <?php $__errorArgs = ['library_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>


        <!-- Tombol Submit -->
        <div class="text-center">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                           text-white px-6 py-3 rounded-full font-medium shadow-lg transition-all duration-300">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>Daftar Sekarang</span>
            </button>
        </div>
    </form>
</div>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/users/anggota-daftar.blade.php ENDPATH**/ ?>