<?php

use App\Http\Controllers\{ProfileController, UserController, ExpenseController, WishController};
use App\Http\Middleware\{Admin, Client};
use Illuminate\Support\Facades\Route;

Route::middleware(Client::class)->group(function () {
    Route::get('/dashboard', [UserController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');
    Route::view('/profile', "profile.index")->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/expense/add', [ExpenseController::class, "addView"])->name('expense.add');
    Route::post('/expense/add', [ExpenseController::class, "add"])->name('expense.insert');
    Route::delete('/expense', [ExpenseController::class, 'destroy'])->name('expense.delete');
    Route::get('/wishes', [WishController::class, 'index'])->name('wish-list');
    Route::post('/wish', [WishController::class, 'store'])->name('wish.store');
    Route::delete('/wish', [WishController::class, 'destroy'])->name('wish.destroy');
    Route::put('/wish', [WishController::class, 'update'])->name('wish.update');
});

Route::middleware(Admin::class)->group(function () {
    Route::get('/admin/dashboard', [UserController::class, "adminIndex"])->middleware(['auth', 'verified'])->name('admin.dashboard');
    Route::get('/admin/users', [UserController::class, 'adminUsers'])->name('admin.users');
    Route::delete('/admin/users', [UserController::class, 'adminUsersDestroy'])->name('admin.users.delete');
    Route::view('/admin/categories', 'admin.categories')->name('admin.categories');
});

require __DIR__ . '/auth.php';
