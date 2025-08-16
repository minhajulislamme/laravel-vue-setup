<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Ecommerce/Home');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Super Admin Routes
Route::middleware(['auth', 'verified', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // Super Admin User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [SuperAdminUserController::class, 'index'])->name('index');
        Route::get('/create', [SuperAdminUserController::class, 'create'])->name('create');
        Route::post('/', [SuperAdminUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [SuperAdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [SuperAdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [SuperAdminUserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/toggle-status', [SuperAdminUserController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/bulk-action', [SuperAdminUserController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export', [SuperAdminUserController::class, 'export'])->name('export');
    });

    // Super Admin Settings
    Route::get('/settings', function () {
        return Inertia::render('SuperAdmin/Settings');
    })->name('settings');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin User Management (only regular users)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');
    });
});

// User Routes
Route::middleware(['auth', 'verified', 'role:user,admin,super_admin'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // User Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserProfileController::class, 'show'])->name('show');
        Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::put('/', [UserProfileController::class, 'update'])->name('update');
        Route::put('/password', [UserProfileController::class, 'updatePassword'])->name('update-password');
    });
});

// Ecommerce Routes (Public)
Route::group([], function () {
    Route::get('/products', function () {
        return Inertia::render('Ecommerce/Products');
    })->name('products');

    Route::get('/categories', function () {
        return Inertia::render('Ecommerce/Categories');
    })->name('categories');

    Route::get('/categories/{category}', function ($category) {
        return Inertia::render('Ecommerce/CategoryProducts', [
            'category' => $category
        ]);
    })->name('categories.show');

    Route::get('/products/{product}', function ($product) {
        return Inertia::render('Ecommerce/ProductDetails', [
            'productId' => $product
        ]);
    })->name('products.show');

    Route::get('/cart', function () {
        return Inertia::render('Ecommerce/Cart');
    })->name('cart');

    Route::get('/wishlist', function () {
        return Inertia::render('Ecommerce/Wishlist');
    })->name('wishlist');

    Route::get('/checkout', function () {
        return Inertia::render('Ecommerce/Checkout');
    })->name('checkout');

    Route::get('/order-confirmation/{orderNumber}', function ($orderNumber) {
        return Inertia::render('Ecommerce/OrderConfirmation', [
            'orderNumber' => $orderNumber
        ]);
    })->name('order.confirmation');

    Route::get('/search', function () {
        return Inertia::render('Ecommerce/SearchResults');
    })->name('search');

    Route::get('/offers', function () {
        return Inertia::render('Ecommerce/Offers');
    })->name('offers');

    Route::get('/contact', function () {
        return Inertia::render('Ecommerce/Contact');
    })->name('contact');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
