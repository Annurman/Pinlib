

<?php $__env->startSection('content'); ?>
<div class="container mt-4">

    <!-- Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 text-center">Daftar Buku</h2>
        
    </div>
<!-- Form Pencarian -->
<form method="GET" class="row mb-4">
    <div class="col-md-3">
        <label for="filter_by" class="form-label">Cari Berdasarkan</label>
        <select name="filter_by" class="form-select">
            <option value="title" <?php echo e(request('filter_by') == 'title' ? 'selected' : ''); ?>>Judul</option>
            <option value="author" <?php echo e(request('filter_by') == 'author' ? 'selected' : ''); ?>>Penulis</option>
            <option value="isbn" <?php echo e(request('filter_by') == 'isbn' ? 'selected' : ''); ?>>ISBN</option>
            <option value="publisher" <?php echo e(request('filter_by') == 'publisher' ? 'selected' : ''); ?>>Penerbit</option>
            <option value="year" <?php echo e(request('filter_by') == 'year' ? 'selected' : ''); ?>>Tahun</option>
        </select>
    </div>

    <div class="col-md-5">
        <label for="search" class="form-label">Kata Kunci</label>
        <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Masukkan kata kunci...">
    </div>

    <div class="col-md-2 d-flex flex-column gap-2 align-items-end justify-content-end">
        <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-search me-1"></i> Cari
        </button>
        <a href="<?php echo e(route('books.create')); ?>" class="btn btn-success w-100">
            <i class="fas fa-plus me-1"></i> Tambah Buku
        </a>
    </div>
</form>



    <!-- Alert Success -->
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- Tabel Daftar Buku -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>ISBN</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($book->title); ?></td>
                    <td><?php echo e($book->author); ?></td>
                    <td><?php echo e($book->publisher); ?></td>
                    <td><?php echo e($book->year); ?></td>
                    <td><?php echo e($book->isbn); ?></td>
                    <td class="text-center"><?php echo e($book->stock); ?></td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm me-1 edit-btn" 
                            data-id="<?php echo e($book->id); ?>" 
                            data-title="<?php echo e($book->title); ?>" 
                            data-author="<?php echo e($book->author); ?>" 
                            data-publisher="<?php echo e($book->publisher); ?>" 
                            data-year="<?php echo e($book->year); ?>" 
                            data-isbn="<?php echo e($book->isbn); ?>" 
                            data-stock="<?php echo e($book->stock); ?>">
                            Edit
                        </button>
                        <form action="<?php echo e(route('books.destroy', $book->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>     
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL EDIT BUKU -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editBookForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="edit-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-author" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="edit-author" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-publisher" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="edit-publisher" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-year" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="edit-year" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="edit-isbn" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="edit-stock" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".edit-btn").click(function () {
        $("#edit-id").val($(this).data("id"));
        $("#edit-title").val($(this).data("title"));
        $("#edit-author").val($(this).data("author"));
        $("#edit-publisher").val($(this).data("publisher"));
        $("#edit-year").val($(this).data("year"));
        $("#edit-isbn").val($(this).data("isbn"));
        $("#edit-stock").val($(this).data("stock"));

        $("#editBookModal").modal("show");
    });

    $("#editBookForm").submit(function (e) {
        e.preventDefault();

        let id = $("#edit-id").val();
        let _token = $("input[name=_token]").val();

        $.ajax({
            url: "<?php echo e(route('books.update', ':id')); ?>".replace(':id', id),
            type: "PUT",
            data: {
                _token: _token,
                title: $("#edit-title").val(),
                author: $("#edit-author").val(),
                publisher: $("#edit-publisher").val(),
                year: $("#edit-year").val(),
                isbn: $("#edit-isbn").val(),
                stock: $("#edit-stock").val()
            },
            success: function () {
                alert("Buku berhasil diperbarui!");
                location.reload();
            },
            error: function (xhr) {
                alert("Terjadi kesalahan saat menyimpan.");
                console.error(xhr.responseText);
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\perpus\perpustakaan-online\resources\views/books/index.blade.php ENDPATH**/ ?>