
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
}); 

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


Route::get('/invitations/{token}', [InvitationController::class,'acceptForm',])->name('invitations.accept');

Route::post('/invitations/{token}', [InvitationController::class,'accept',])->name('invitations.accept.store');

Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {
    Route::get('/superadmin/invitations/create', [InvitationController::class,'createCompanyAdmin',])->name('superadmin.invitations.create');
    Route::post('/superadmin/invitations', [InvitationController::class,'storeCompanyAdmin',])->name('superadmin.invitations.store');

});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/invitations/create', [InvitationController::class,'createCompanyInvitation',])->name('admin.invitations.create');
    Route::post('/admin/invitations', [InvitationController::class,'storeCompanyInvitation',])->name('admin.invitations.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $route = match (auth()->user()->role) {
            'SuperAdmin' => 'superadmin.dashboard',
            'Admin' => 'admin.dashboard',
            'Member' => 'member.dashboard',
            'Sales' => 'sales.dashboard',
            'Manager' => 'manager.dashboard',
            default => abort(403),
        };

        return redirect()->route($route);
    })->name('dashboard');

    Route::get('/superadmin/dashboard', function () { return view('dashboard');})->middleware('role:SuperAdmin')->name('superadmin.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('dashboard');})->middleware('role:Admin')->name('admin.dashboard');

    Route::get('/member/dashboard', function () {
        return view('dashboard');})->middleware('role:Member')->name('member.dashboard');

    Route::get('/sales/dashboard', function () {
        return view('dashboard');})->middleware('role:Sales')->name('sales.dashboard');

    Route::get('/manager/dashboard', function () {
        return view('dashboard');})->middleware('role:Manager')->name('manager.dashboard');

    Route::get('/short-urls', [ShortUrlController::class, 'index'])->middleware('role:SuperAdmin,Admin,Member')->name('short-urls.index');

Route::get('/short-urls/create', [ShortUrlController::class, 'create'])
    ->middleware('role:Admin,Member')
    ->name('short-urls.create');

Route::post('/short-urls', [ShortUrlController::class, 'store'])
    ->middleware('role:Admin,Member')
    ->name('short-urls.store');

});

Route::get('/{shortCode}', [ShortUrlController::class, 'redirect'])
    ->where('shortCode', '[A-Za-z0-9]{7}')
    ->name('short-urls.redirect');