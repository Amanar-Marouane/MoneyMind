<?php

use App\Http\Controllers\{ProfileController, UserController, ExpenseController};
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');
    Route::view('/profile', "profile.index")->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/expense/add', [ExpenseController::class, "addView"])->name('expense.add');
    Route::post('/expense/add', [ExpenseController::class, "add"])->name('expense.insert');
    Route::delete('/expense', [ExpenseController::class, 'destroy'])->name('expense.delete');
});

require __DIR__ . '/auth.php';
