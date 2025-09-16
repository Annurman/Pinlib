<?php $__env->startSection('content'); ?>
<meta name="admin-id" content="<?php echo e(auth('admin')->id()); ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

<div class="container mt-5">


    <h2 class="text-center text-primary fw-bold" data-aos="fade-down">Selamat Datang di Dashboard!</h2>
    <p class="text-center text-muted" data-aos="fade-up">Kelola data perpustakaan dengan mudah</p>
    


    <div class="row mt-4 g-4">

        <!-- Kotak Peminjaman -->
        <div class="col-md-6 col-lg-3" data-aos="zoom-in">
            <div class="card shadow border-0 h-100 hover-shadow" style="border-top: 4px solid #0d6efd;">
                <div class="card-body text-center">
                    <h5 class="text-muted">📚 Peminjaman Minggu Ini</h5>
                    <h3 class="text-primary fw-bold"><?php echo e($borrowingsThisWeek ?? 0); ?></h3>
                </div>
            </div>
        </div>

        <!-- Kotak Pengembalian -->
        <div class="col-md-6 col-lg-3" data-aos="zoom-in">
            <div class="card shadow border-0 h-100 hover-shadow" style="border-top: 4px solid #198754;">
                <div class="card-body text-center">
                    <h5 class="text-muted">🔄 Pengembalian Minggu Ini</h5>
                    <h3 class="text-success fw-bold"><?php echo e($returnsThisWeek ?? 0); ?></h3>
                </div>
            </div>
        </div>

        <!-- Kotak Jumlah Buku -->
        <div class="col-md-6 col-lg-3" data-aos="zoom-in">
            <div class="card shadow border-0 h-100 hover-shadow" style="border-top: 4px solid #fd7e14;">
                <div class="card-body text-center">
                    <h5 class="text-muted">📘 Total Buku</h5>
                    <h3 class="text-warning fw-bold"><?php echo e($totalBooks ?? 0); ?></h3>
                </div>
            </div>
        </div>

        <!-- Kotak Jumlah Member -->
        <div class="col-md-6 col-lg-3" data-aos="zoom-in">
            <div class="card shadow border-0 h-100 hover-shadow" style="border-top: 4px solid #6f42c1;">
                <div class="card-body text-center">
                    <h5 class="text-muted">👥 Total Member</h5>
                    <h3 class="text-purple fw-bold" style="color: #6f42c1;"><?php echo e($totalMembers ?? 0); ?></h3>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Optional CSS tambahan untuk hover animasi -->
<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        transition: 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
</style>


    <!-- Notifikasi Aktivitas -->
    <div class="card mt-4 shadow-sm" data-aos="fade-up" id="admin-notification-box">
        <div class="card-header bg-primary text-white">
            <strong>📢 Notifikasi Aktivitas Terbaru</strong>
        </div>
        <?php if(auth()->check() && auth()->user() instanceof \App\Models\Admin): ?>
    <?php $__currentLoopData = auth()->user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-3 flex justify-between items-center rounded-lg shadow">
            <div>
                <p class="font-medium"><?php echo e($notification->data['message']); ?></p>
            </div>
            <div class="flex gap-2">
                <?php if(isset($notification->data['link'])): ?>
                    <a href="<?php echo e($notification->data['link']); ?>"
                       class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                        Pergi ke halaman
                    </a>
                <?php endif; ?>
                <form action="<?php echo e(route('admin.notifications.read', $notification->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="text-sm text-gray-500 hover:underline">Tandai telah dibaca</button>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init();
</script>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    window.adminId = <?php echo e(Auth::guard('admin')->id()); ?>;
</script>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/dashboard.blade.php ENDPATH**/ ?>