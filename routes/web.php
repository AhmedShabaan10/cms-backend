<?php

use App\Http\Controllers\UiController\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UiController\DashboardController;
use App\Http\Controllers\UiController\OrdersController;
use App\Http\Controllers\UiController\ProductController;
use App\Http\Controllers\UiController\ProfileController;
use App\Http\Controllers\UiController\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/profile/logout', [AuthenticatedSessionController::class, 'logout'])->name('profile.logout');

    Route::get('/users', [ProfileController::class, 'listUsers'])->name('users.list');
    Route::get('/users/{user}/edit', [ProfileController::class, 'editUser'])->name('edit.users');
    Route::put('/users/{user}', [ProfileController::class, 'updateUser'])->name('update.users');
    Route::delete('/users/{user}', [ProfileController::class, 'destroyUser'])->name('destroy.users');
    Route::get('/create-user', [ProfileController::class, 'createUser'])->name('create.users');
    Route::post('store-user', [ProfileController::class, 'storeUser'])->name('store.user');

    Route::get('roles', action: [RoleController::class, 'index'])->name('roles.list');
    Route::get('roles/create', action: [RoleController::class, 'create'])->name('create.roles');
    Route::post('roles/store', action: [RoleController::class, 'store'])->name('store.roles');
    Route::get('roles/{id}/edit', action: [RoleController::class, 'edit'])->name('edit.roles');
    Route::put('roles/{id}', action: [RoleController::class, 'update'])->name('update.roles');
    Route::delete('roles/{id}', action: [RoleController::class, 'destroy'])->name('destroy.roles');

    Route::get('/products', [ProductController::class, 'index'])->name('list.products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('create.products');
    Route::post('/products/store', [ProductController::class, 'store'])->name('store.products');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('edit.products');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update.products');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('destroy.products');

    Route::get('/orders', [OrdersController::class, 'index'])->name('list.orders');
    Route::get('/orders/{id}', [OrdersController::class, 'show'])->name('show.orders');
    Route::get('/orders/{id}/edit', [OrdersController::class, 'edit'])->name('edit.orders');
    Route::put('/orders/{id}', [OrdersController::class, 'update'])->name('update.orders');

});

require __DIR__ . '/auth.php';
