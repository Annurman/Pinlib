<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MemberRegistrationController;
use App\Http\Controllers\User\BorrowingController as UserBorrowingController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Admin\PasswordResetController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin (login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'create'])->name('login');
        Route::post('/login', [AuthController::class, 'store']);
    });

    // Authenticated admin
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Manage admin
        Route::get('/register', [AdminProfileController::class, 'create'])->name('create');
        Route::post('/register', [AdminProfileController::class, 'store'])->name('store');

        // Profile
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');

        // Notifications
        Route::patch('/notifications/{id}/read', function ($id) {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();
            return back();
        })->name('notifications.read');

        // Members
        Route::patch('/members/{member}/approve', [MemberController::class, 'approve'])->name('members.approve');

        // Borrowings
        Route::resource('borrowings', BorrowingController::class)->only(['index', 'destroy']);
        Route::put('borrowings/{id}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
        Route::patch('/borrowings/{borrowing}/mark-found', [BorrowingController::class, 'markAsFound'])->name('borrowings.mark.found');

        // Books
        Route::resource('books', BookController::class);

        // Scan page
        Route::get('/scan', fn() => view('scan'))->name('scan');

        // Members management
        Route::resource('members', MemberController::class)->except(['edit']);

    });

    // Password reset (public)
    Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->name('password.update');

});


/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

// Guest user login
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Authenticated user
Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard
    Route::get('/users/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');

    // Profile
    Route::get('/users/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/users/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/users/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/users/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Member registration
    Route::get('/users/anggota', [MemberRegistrationController::class, 'index'])->name('member.index');
    Route::get('/anggota/daftar', [MemberRegistrationController::class, 'create'])->name('daftar.form');
    Route::post('/anggota/daftar', [MemberRegistrationController::class, 'store'])->name('daftar.store');
    Route::get('/users/card/{id}', [MemberRegistrationController::class, 'showCard'])->name('member.card');

    // Borrowings (user)
    Route::prefix('users')->group(function () {
        Route::get('/borrowings/create', [UserBorrowingController::class, 'create'])->name('users.borrowings.create');
        Route::post('/borrowings', [UserBorrowingController::class, 'store'])->name('users.borrowings.store');
        Route::get('/borrowings', [UserBorrowingController::class, 'index'])->name('users.borrowings.index');
        Route::get('/borrowings/{borrowing}', [UserBorrowingController::class, 'show'])->name('borrowings.show');
        Route::patch('/borrowings/{borrowing}/return-request', [UserBorrowingController::class, 'requestReturn'])
            ->name('borrowings.return.request');
        Route::patch('/borrowings/{borrowing}/approve-return', [UserBorrowingController::class, 'approveReturn'])
            ->name('borrowings.approveReturn');
        Route::patch('/borrowings/{borrowing}/report-lost', [UserBorrowingController::class, 'reportLost'])
            ->name('borrowings.report.lost');
    });
});


/*
|--------------------------------------------------------------------------
| MISC
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'));

Broadcast::routes(['middleware' => ['auth']]);

require __DIR__.'/auth.php';
