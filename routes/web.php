<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Dashboard\WireDashboard;
use App\Livewire\Pages\Auth\WireAuth;

use Livewire\Volt\Volt;

// Route::get('/', [AuthenticatedSessionController::class, 'create'])
//                 ->name('login');

Route::middleware('guest')->group(function () {
    // Volt::route('register', 'pages.auth.register')
    //     ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

        Volt::route('/', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');

    // Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirectSocial'])
    //     ->name('socialite.redirect');

    // Route::get('auth/{provider}/callback', [SocialiteController::class, 'callbackSocial'])
    //     ->name('socialite.callback');

});

// Route::get('/', AuthPage::class)->name('root.auth-page');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', WireDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/app_routes/role_routes.php';

require __DIR__.'/app_routes/clearance_area_routes.php';

require __DIR__.'/app_routes/clearance_type_routes.php';

require __DIR__.'/app_routes/clearance_routes.php';

require __DIR__.'/app_routes/access_permission_routes.php';

require __DIR__.'/app_routes/permission_request_routes.php';

require __DIR__.'/app_routes/clearance_faculty_hed_routes.php';

require __DIR__.'/app_routes/clearance_support_service_personnel_routes.php';

require __DIR__.'/app_routes/clearance_management_routes.php';

require __DIR__.'/app_routes/clearance_employee_clearance_routes.php';

require __DIR__.'/app_routes/clearance_employee_enrollment_routes.php';

require __DIR__.'/app_routes/individual_employee_clearance_routes.php';

require __DIR__.'/app_routes/view_individual_employee_clearance_routes.php';

require __DIR__.'/app_routes/send_email_routes.php';

require __DIR__.'/app_routes/my_clearance_routes.php';

require __DIR__.'/app_routes/my_clearance_detail_routes.php';

require __DIR__.'/auth.php';
