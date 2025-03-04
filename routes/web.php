<?php

use App\Http\Controllers\{AlertController, ProfileController, UserController, ExpenseController, WishController, CategoryController, DepositController};
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
    Route::post('/wish/buy', [WishController::class, 'buy'])->name('wish.buy');

    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');
    Route::put('/alerts', [AlertController::class, 'update'])->name('alerts.update');
    Route::delete('/alerts', [AlertController::class, 'destroy'])->name('alerts.destroy');

    Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits', [DepositController::class, 'store'])->name('deposits.store');
});

Route::middleware(Admin::class)->group(function () {
    Route::get('/admin/dashboard', [UserController::class, "adminIndex"])->middleware(['auth', 'verified'])->name('admin.dashboard');

    Route::get('/admin/users', [UserController::class, 'adminUsers'])->name('admin.users');
    Route::delete('/admin/users', [UserController::class, 'adminUsersDestroy'])->name('admin.users.delete');

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::put('/admin/categories', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/admin/categories', [CategoryController::class, 'destroy'])->name('category.destroy');
});

require __DIR__ . '/auth.php';
