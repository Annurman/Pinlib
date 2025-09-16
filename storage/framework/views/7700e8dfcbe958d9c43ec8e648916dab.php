

<?php $__env->startSection('content'); ?>

<!-- Tambahkan CDN AOS, Anime.js, dan Swiper.js untuk animasi tambahan -->
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.js"></script>
</head>
<div class="flex flex-col min-h-screen mt-16">
<!-- Hero Section dengan Carousel -->
<section class="relative w-full h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="swiper mySwiper h-full">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="<?php echo e(asset('storage/profile_pictures/perpus3.png')); ?>" class="w-full h-full object-cover" alt="Profile Image"></div>
                <div class="swiper-slide"><img src="<?php echo e(asset('storage/profile_pictures/perpus2.jpeg')); ?>" class="w-full h-full object-cover" alt="Profile Image"></div>
                <div class="swiper-slide"><img src="<?php echo e(asset('storage/profile_pictures/perpus1.jpeg')); ?>" class="w-full h-full object-cover" alt="Profile Image"></div>
            </div>
        </div>
    </div>
    <div class="relative z-10 text-center" data-aos="fade-up">
        <h1 class="text-5xl font-bold mb-4">Selamat Datang di Pinlib</h1>
        <p class="text-lg">Platform Peminjaman Buku Online Terbaik</p>
    </div>
</section>

<!-- Apa Itu Pinlib -->
<section class="py-16 px-8 bg-white text-center" data-aos="fade-up">
    <h2 class="text-3xl font-bold mb-4">Apa Itu Pinlib?</h2>
    <p class="text-lg">Pinlib adalah platform perpustakaan digital yang memungkinkan pengguna untuk mencari, meminjam, dan membaca buku secara online dengan mudah.</p>
</section>

<!-- Visi Misi -->
<section class="py-16 px-8 bg-gray-100 text-center" data-aos="fade-up">
    <h2 class="text-3xl font-bold mb-4">Visi & Misi</h2>
    <p class="text-lg">Visi kami adalah memberikan akses perpustakaan digital kepada semua orang. Misi kami adalah menyediakan koleksi buku berkualitas dan kemudahan dalam peminjaman buku online.</p>
</section>

<!-- Statistik Singkat -->
<section class="py-16 px-8 bg-white text-center" data-aos="fade-up">
    <h2 class="text-3xl font-bold mb-4">Statistik Singkat</h2>
    <div class="grid grid-cols-3 gap-6 text-lg">
        <div><span class="text-4xl font-bold">500+</span> Buku Tersedia</div>
        <div><span class="text-4xl font-bold">1000+</span> Pengguna Aktif</div>
        <div><span class="text-4xl font-bold">200+</span> Peminjaman per Hari</div>
    </div>
</section>

<!-- Testimoni Pengguna -->
<section class="py-16 px-8 bg-gray-100 text-center" data-aos="fade-up">
    <h2 class="text-3xl font-bold mb-4">Testimoni Pengguna</h2>
    <p class="text-lg italic">"Pinlib sangat membantu saya dalam mencari buku favorit saya!" - Rina</p>
</section>

<!-- Call to Action -->
<section class="py-16 px-8 bg-blue-600 text-white text-center" data-aos="fade-up">
    <h2 class="text-3xl font-bold mb-4">Mulai Sekarang</h2>
    <p class="text-lg mb-4">Daftar sekarang dan nikmati kemudahan perpustakaan digital.</p>
    <a href="<?php echo e(route('register')); ?>" class="px-6 py-3 bg-white text-blue-600 font-bold rounded-lg shadow-md hover:bg-gray-200 transition">Daftar Sekarang</a>
</section>

<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
    });
    AOS.init();
</script>

<!-- Copyright -->
<footer class="bg-gray-900 text-white text-center py-4 mt-16" >
    <p>&copy; 2025 Pinlib. All Rights Reserved.</p>
</footer>
</div>
<script>
    <?php if(auth()->guard()->check()): ?>
        Echo.private('user.<?php echo e(auth()->id()); ?>')
            .listen('.book.return.approved', (e) => {
                alert(e.'Pengembalian anda telah di approved'); // ganti dengan notifikasi UI kalau mau
            });
    <?php endif; ?>
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online_1\resources\views/users/dashboard.blade.php ENDPATH**/ ?>