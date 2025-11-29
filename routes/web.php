<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MemberRegistrationController;
use App\Http\Controllers\User\BorrowingController as UserBorrowingController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Admin\PasswordResetController;

// =====================
// 🔹 ROUTE ADMIN
// =====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
       Route::post('login', [AuthController::class, 'store']);
    });
    
    

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [AuthController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // Admin hanya bisa dibuat oleh admin lain
        Route::get('/admin/register', [AdminProfileController::class, 'create'])->name('create');
        Route::post('/admin/register', [AdminProfileController::class, 'store'])->name('store');
    
        // Profile admin
        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [AdminProfileController::class, 'update'])->name('profile.update');


        
    
    });

    Route::patch('/admin/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
    
        return back();
    })->name('notifications.read')->middleware('auth:admin');
    
    Route::patch('/admin/members/{member}/approve', [MemberController::class, 'approve'])->name('members.approve');
    Route::get('borrowings', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');



});

Route::middleware(['auth:admin'])->group(function () {
    Route::resource('members', MemberController::class);
    Route::delete('/borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');


    Route::resource('members', MemberController::class)->except(['edit']);
        Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::resource('books', BookController::class);

    
Route::get('/scan', function () {
    return view('scan');
})->name('scan');
;


Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
Route::get('/', function () {
    return view('welcome');
});

Route::put('/borrowings/{id}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
    Route::get('/borrowings', [BorrowingController::class, 'index']);
    Route::patch('/borrowings/{borrowing}/mark-found', [BorrowingController::class, 'markAsFound'])->name('borrowings.mark.found');


});


// Form request reset password
Route::get('admin/forgot-password', [PasswordResetController::class, 'requestForm'])
    ->name('admin.password.request');

// Proses kirim email reset
Route::post('admin/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('admin.password.email');

// Form reset password (link dari email)
Route::get('admin/reset-password/{token}', [PasswordResetController::class, 'resetForm'])
    ->name('admin.password.reset');

// Proses update password
Route::post('admin/reset-password', [PasswordResetController::class, 'updatePassword'])
    ->name('admin.password.update');

// =====================
// 🔹 ROUTE USER
// =====================
Route::middleware(['guest:web'])->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth:web'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    
});

Route::middleware(['auth'])->prefix('users')->group(function () {
    Route::get('borrowings/create', [UserBorrowingController::class, 'create'])->name('users.borrowings.create');
    Route::post('borrowings', [UserBorrowingController::class, 'store'])->name('users.borrowings.store');
    Route::get('borrowings/index', [UserBorrowingController::class, 'index'])->name('users.borrowings.index');
    Route::get('borrowings/{borrowing}', [UserBorrowingController::class, 'show'])->name('borrowings.show');
      Route::patch('/borrowings/{borrowing}/return-request', [UserBorrowingController::class, 'requestReturn'])
        ->name('borrowings.return.request');
Route::patch('/borrowings/{borrowing}/approve-return', [UserBorrowingController::class, 'approveReturn'])->name('borrowings.approveReturn');
});
Route::patch('/borrowings/{borrowing}/report-lost', [UserBorrowingController::class, 'reportLost'])
->name('borrowings.report.lost');


Route::get('/users/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('users/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('users/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('users/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('users/profile', [ProfileController::class, 'show'])->name('profile.show');

});



Route::middleware(['auth'])->group(function () {
    Route::get('users/anggota', [MemberRegistrationController::class, 'index'])->name('member.index');
    Route::get('/anggota/daftar', [MemberRegistrationController::class, 'create'])->name('daftar.form');
    Route::post('/anggota/daftar', [MemberRegistrationController::class, 'store'])->name('daftar.store');    
    Route::get('users/card/{id}', [MemberRegistrationController::class, 'showCard'])->name('member.card');

});


Route::middleware('api')
    ->prefix('api')
    ->group(base_path('routes/api.php'));

    Broadcast::routes(['middleware' => ['auth']]);

require __DIR__.'/auth.php';
