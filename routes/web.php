<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MemberRegistrationController;
use App\Http\Controllers\User\BorrowingController as UserBorrowingController;
use App\Http\Controllers\Admin\PasswordResetController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/scan', 'scan')->name('scan');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin login
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        Route::post('login', [AuthController::class, 'store']);
    });

    // Admin authenticated
    Route::middleware('auth:admin')->group(function () {

        Route::get('dashboard', [AuthController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // Admin register (only admin)
        Route::get('register', [AdminProfileController::class, 'create'])->name('create');
        Route::post('register', [AdminProfileController::class, 'store'])->name('store');

        // Profile admin
        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [AdminProfileController::class, 'update'])->name('profile.update');

        // Members
        Route::resource('members', MemberController::class);
        Route::patch('members/{member}/approve', [MemberController::class, 'approve'])->name('members.approve');

        // Books
        Route::resource('books', BookController::class);

        // Borrowings
        Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
        Route::delete('borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');
        Route::put('borrowings/{id}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
        Route::patch('borrowings/{borrowing}/mark-found', [BorrowingController::class, 'markAsFound'])->name('borrowings.mark.found');

        // Notifications
        Route::patch('notifications/{id}/read', function ($id) {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();
            return back();
        })->name('notifications.read');

    });

});

/*
|--------------------------------------------------------------------------
| ADMIN PASSWORD RESET
|--------------------------------------------------------------------------
*/

Route::get('admin/forgot-password', [PasswordResetController::class, 'requestForm'])->name('admin.password.request');
Route::post('admin/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('admin.password.email');
Route::get('admin/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('admin.password.reset');
Route::post('admin/reset-password', [PasswordResetController::class, 'updatePassword'])->name('admin.password.update');

/*
|--------------------------------------------------------------------------
| USER AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest:web')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:web')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('users')->name('users.')->group(function () {

    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Borrowings
    Route::get('borrowings/create', [UserBorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('borrowings', [UserBorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('borrowings', [UserBorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('borrowings/{borrowing}', [UserBorrowingController::class, 'show'])->name('borrowings.show');
    Route::patch('borrowings/{borrowing}/return-request', [UserBorrowingController::class, 'requestReturn'])->name('borrowings.return.request');
    Route::patch('borrowings/{borrowing}/approve-return', [UserBorrowingController::class, 'approveReturn'])->name('borrowings.approveReturn');
    Route::patch('borrowings/{borrowing}/report-lost', [UserBorrowingController::class, 'reportLost'])->name('borrowings.report.lost');

    // Membership
    Route::get('anggota', [MemberRegistrationController::class, 'index'])->name('member.index');
    Route::get('anggota/daftar', [MemberRegistrationController::class, 'create'])->name('member.register.form');
    Route::post('anggota/daftar', [MemberRegistrationController::class, 'store'])->name('member.register.store');
    Route::get('card/{id}', [MemberRegistrationController::class, 'showCard'])->name('member.card');

});

/*
|--------------------------------------------------------------------------
| API + BROADCAST
|--------------------------------------------------------------------------
*/
Route::get('/dev-routes', function () {
    return collect(\Route::getRoutes())->map(function ($r) {
        return [
            'uri' => $r->uri(),
            'method' => $r->methods(),
            'name' => $r->getName(),
            'middleware' => $r->middleware(),
        ];
    });
});

Route::prefix('api')->middleware('api')->group(base_path('routes/api.php'));
Broadcast::routes(['middleware' => ['auth']]);

require __DIR__.'/auth.php';
