
    <!-- Tambahkan CDN AOS, Anime.js, dan Swiper.js untuk animasi tambahan -->
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>

    </head>

    <!-- Navbar -->
    <div class="navbar fixed top-0 left-0 w-full bg-gradient-to-r from-[#96B8F2] to-[#F5F7FA]  text-white p-2 flex justify-between items-center shadow-md z-50">
    <div class="flex items-center px-4">
        <img src="<?php echo e(asset('storage/profile_pictures/logo-pinlib.png')); ?>" alt="Pinlib Logo" style="width: 60px; height: 60px;" class="ml-4">
        <h2 class="text-lg font-bold tracking-wide">Pinlib</h2>
    </div>
        <button onclick="openSidebar()" class="menu-btn text-2xl hover:text-gray-300 transition-transform transform hover:scale-110 md:block hidden absolute left-4 top-5">&#9776;</button>
        <div class="nav-links flex gap-4 items-center">
        <?php if(Auth::guard('web')->check()): ?>
    <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow transition-transform transform hover:scale-105 absolute right-4 top-4">
            Logout
        </button>
    </form>
<?php else: ?>
<div class="relative flex items-center bg-white rounded-lg overflow-hidden shadow-md w-48 md:absolute md:right-4">
                    <a href="<?php echo e(route('admin.login')); ?>" class="flex-1 text-center py-3 transition-all duration-300 bg-gray-700 text-white hover:bg-gray-300 hover:text-black">Admin</a>
                    <a href="<?php echo e(route('login')); ?>" class="flex-1 text-center py-3 transition-all duration-300 bg-green-500 text-white hover:bg-green-300 hover:text-black">User</a>
                </div>
<?php endif; ?>

        </div>
    </div>

   

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar fixed top-0 left-[-100%] w-64 h-full bg-gray-900 text-white p-5 transition-all duration-300 shadow-lg z-50 bg-white/30 backdrop-blur-md shadow-lg">
        <button onclick="closeSidebar()" class="close-btn text-2xl absolute top-4 right-4 hover:text-gray-400 transition-transform transform hover:rotate-90">&times;</button>

        <div class="profile text-center mt-8" data-aos="fade-right">
            <?php
                $user = Auth::guard('web')->user();
                $admin = Auth::guard('admin')->user();
                $profileImage = asset('storage/profile_pictures/default.png');
                if ($user) {
    $profileImage = $user->profile && $user->profile->profile_image
        ? asset('storage/' . $user->profile->profile_image)
        : $profileImage;
} elseif ($admin) {
                    $profileImage = $admin->profile_image ? asset('storage/' . $admin->profile_image) : $profileImage;
                }
            ?>

            <img src="<?php echo e($profileImage); ?>" alt="Profile Image" class="profile-img w-24 h-24 rounded-full mx-auto border-4 border-white shadow-lg hover:shadow-xl transition duration-300"> <h5>
                <?php if($user): ?>
                    <?php echo e($user->name); ?>

                <?php elseif($admin): ?>
                    <?php echo e($admin->name); ?>

                <?php else: ?>
                    Guest
                <?php endif; ?>
            </h5>
        </div>

        <!-- Menu Sidebar -->
        <ul class="menu mt-8 space-y-4 ">
    <li>
        <a href="<?php echo e(route('users.dashboard')); ?>" class="flex items-center gap-3 px-6 py-3 bg-purple-600 hover:bg-purple-700 rounded-lg shadow-md transition-transform transform hover:scale-105" data-aos="fade-up" data-aos-delay="200">
            <i data-feather="home"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="<?php echo e(url('users/profile')); ?>" class="flex items-center gap-3 px-6 py-3 bg-yellow-600 hover:bg-yellow-700 rounded-lg shadow-md transition-transform transform hover:scale-105" data-aos="fade-up">
            <i data-feather="user"></i> Profile
        </a>
    </li>
    <li>
        <a href="<?php echo e(route('member.index')); ?>" class="flex items-center gap-3 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-transform transform hover:scale-105" data-aos="fade-up">
            <i data-feather="users"></i> Anggota
        </a>
    </li>
    <li>
        <a href="<?php echo e(route('users.borrowings.index')); ?>" class="flex items-center gap-3 px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg shadow-md transition-transform transform hover:scale-105" data-aos="fade-up" data-aos-delay="100">
            <i data-feather="book-open"></i> Peminjaman
        </a>
    </li>
</ul>

    </div>

    <script>
        function openSidebar() {
            document.getElementById("sidebar").style.left = "0";
        }
        function closeSidebar() {
            document.getElementById("sidebar").style.left = "-100%";
        }
        document.addEventListener("DOMContentLoaded", function () {
            AOS.init();
            feather.replace();
        });
    </script>

    <style>
       
        .relative.flex.items-center a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transition: 0.3s ease-in-out;
            color: black !important;
        }
        .relative.flex.items-center a:not(:hover) {
            opacity: 0.7;
        }
        .relative.flex.items-center a:hover {
            opacity: 1;
        }
        @media (max-width: 768px) {
            .navbar { flex-direction: column; text-align: center; }
            .nav-links { flex-direction: column; gap: 2px; }
            .sidebar { width: 100%; left: -100%; }
            .menu-btn { position: absolute; left: 1rem; top: 1rem; display: block; }
            .btn { right: 1rem !important; top: 1rem !important; }
            .relative.flex.items-center { right: 1rem; position: absolute; }
        }
    </style>


<?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online_1\resources\views/layouts/navigation-user.blade.php ENDPATH**/ ?>