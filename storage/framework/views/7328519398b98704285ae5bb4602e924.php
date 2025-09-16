

<?php $__env->startSection('content'); ?>
<div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <!-- Judul Halaman -->
    <h1 class="text-2xl font-semibold mb-4">Profil Admin Perpustakaan</h1>

    <div class="flex items-center space-x-6">
        <!-- Foto Profil -->
        <?php if($admin->adminProfile && $admin->adminProfile->profile_image): ?>
            <img src="<?php echo e(url('storage/' . $admin->adminProfile->profile_image)); ?>" 
                 alt="Foto Profil" 
                 class="w-32 h-32 object-cover rounded-full border-4 border-indigo-500 shadow-md">
        <?php else: ?>
            <div class="w-32 h-32 flex items-center justify-center rounded-full bg-gray-200 text-gray-500">
                Tidak ada foto
            </div>
        <?php endif; ?>

        <!-- Data Profil Admin -->
        <div class="w-full">
        <?php
    $user = Auth::guard('web')->check() ? Auth::guard('web')->user() : null;
    $admin = Auth::guard('admin')->check() ? Auth::guard('admin')->user() : null;
?>
            <table class="w-full border-collapse">
                <tr class="border-b">
                    <th class="p-2 text-gray-600 text-left">Nama</th>
                    <td class="p-2 font-medium"><?php echo e($admin->name); ?></td>
                </tr>
                <tr class="border-b">
                    <th class="p-2 text-gray-600 text-left">Email</th>
                    <td class="p-2 font-medium"><?php echo e($admin->email); ?></td>
                </tr>
                <tr class="border-b">
                    <th class="p-2 text-gray-600 text-left">Nama Perpustakaan</th>
                    <td class="p-2 font-medium"><?php echo e($admin->adminProfile->library_name ?? 'Belum diisi'); ?></td>
                </tr>
                <tr class="border-b">
                    <th class="p-2 text-gray-600 text-left">Alamat Perpustakaan</th>
                    <td class="p-2 font-medium"><?php echo e($admin->adminProfile->library_address ?? 'Belum diisi'); ?></td>
                </tr>
                <tr class="border-b">
                    <th class="p-2 text-gray-600 text-left">Nomor Telepon</th>
                    <td class="p-2 font-medium"><?php echo e($admin->adminProfile->phone_number ?? 'Belum diisi'); ?></td>
                </tr>
            </table>
        </div>
    </div>

   <!-- Tombol untuk membuka modal edit profile -->
<button class="bg-indigo-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-indigo-600 transition duration-300" onclick="openModal()">
    Edit Profil
</button>

<!-- Modal Edit Profil -->
<div id="editProfileModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 max-h-screen overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Edit Profil</h2>
        <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <label class="block font-medium">Nama:</label>
            <input type="text" name="name" value="<?php echo e(Auth::user()->name); ?>" required class="w-full border rounded p-2 mb-2">

            <label class="block font-medium">Email:</label>
            <input type="email" name="email" value="<?php echo e(Auth::user()->email); ?>" required class="w-full border rounded p-2 mb-2">

            <label class="block font-medium">Nama Perpustakaan:</label>
            <input type="text" name="library_name" value="<?php echo e($admin->adminProfile->library_name ?? ''); ?>" class="w-full border rounded p-2 mb-2">

            <label class="block font-medium">Alamat Perpustakaan:</label>
            <textarea name="library_address" class="w-full border rounded p-2 mb-2"><?php echo e($admin->adminProfile->library_address ?? ''); ?></textarea>

            <label class="block font-medium">Telepon:</label>
            <input type="text" name="phone_number" value="<?php echo e($admin->adminProfile->phone_number ?? ''); ?>" class="w-full border rounded p-2 mb-2">

            <label class="block font-medium">Foto Profil:</label>
            <?php if(optional($admin->adminProfile)->profile_image): ?>
    <img src="<?php echo e(asset('storage/' . optional($admin->adminProfile)->profile_image)); ?>" width="100" class="mb-2">
<?php endif; ?>

            <input type="file" name="profile_image" class="w-full border rounded p-2 mb-2">

            <div class="flex justify-end space-x-2">
                <button type="button" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600" onclick="closeModal()">Batal</button>
                <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
</script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/admin/profile.blade.php ENDPATH**/ ?>