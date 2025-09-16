

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 mt-24 animate-fade-in">

    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="<?php echo e(route('users.borrowings.index')); ?>" 
           class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 hover:text-gray-900 
                  rounded-full px-4 py-2 shadow transition duration-300 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Judul -->
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Form Peminjaman Buku</h2>

    <!-- Card Form -->
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6 border">

        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('users.borrowings.store')); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block font-semibold mb-1">Pilih Perpustakaan</label>
                <select name="member_id" required class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih --</option>
                    <?php $__currentLoopData = $memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($membership->id); ?>">
                        <?php echo e($membership->library->profile->library_name ?? 'Perpustakaan ID: ' . $membership->library_id); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">ISBN Buku</label>
                <div class="flex gap-2">
                    <input type="text" name="isbn" id="isbnInput" class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400" required placeholder="Masukkan ISBN">
                    <button type="button" id="cekBukuBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                        Cek Buku
                    </button>
                </div>
            </div>

            <!-- Hidden input untuk book_id -->
            <input type="hidden" name="book_id" id="bookId">

            <!-- Detail buku -->
            <div id="bookFields" class="space-y-2 pt-2">
                <div>
                    <label class="block font-medium text-sm mb-1">Judul Buku</label>
                    <input type="text" id="bookTitle" class="w-full border p-2 rounded bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block font-medium text-sm mb-1">Pengarang</label>
                    <input type="text" id="bookAuthor" class="w-full border p-2 rounded bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block font-medium text-sm mb-1">Penerbit</label>
                    <input type="text" id="bookPublisher" class="w-full border p-2 rounded bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block font-medium text-sm mb-1">Tahun Terbit</label>
                    <input type="text" id="bookYear" class="w-full border p-2 rounded bg-gray-100" readonly>
                </div>
                <div>
                    <label class="block font-medium text-sm mb-1">Stok Tersedia</label>
                    <input type="text" id="bookStock" class="w-full border p-2 rounded bg-gray-100" readonly>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition font-semibold">
                Pinjam Buku
            </button>
        </form>
    </div>
</div>

<!-- AJAX Script -->
<script>
    document.getElementById('cekBukuBtn').addEventListener('click', function () {
        const isbn = document.getElementById('isbnInput').value.trim();

        if (isbn.length >= 5) {
            fetch(`/api/books/${isbn}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.title) {
                        document.getElementById('bookTitle').value = data.title;
                        document.getElementById('bookAuthor').value = data.author;
                        document.getElementById('bookPublisher').value = data.publisher;
                        document.getElementById('bookYear').value = data.year;
                        document.getElementById('bookStock').value = data.stock;
                        document.getElementById('bookId').value = data.id;
                    } else {
                        kosongkanField();
                        alert('Buku tidak ditemukan!');
                    }
                })
                .catch(() => {
                    kosongkanField();
                    alert('Terjadi kesalahan saat mengambil data buku.');
                });
        } else {
            kosongkanField();
            alert('ISBN harus minimal 5 karakter.');
        }
    });

    function kosongkanField() {
        document.getElementById('bookTitle').value = '';
        document.getElementById('bookAuthor').value = '';
        document.getElementById('bookPublisher').value = '';
        document.getElementById('bookYear').value = '';
        document.getElementById('bookStock').value = '';
        document.getElementById('bookId').value = '';
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/users/borrowings/create.blade.php ENDPATH**/ ?>