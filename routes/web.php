<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassTypeController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('Pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //User Management
    Route::resource('users', UserController::class);

    //Class 
    Route::prefix('classes')->group(function () {
        Route::get('/', [ClassTypeController::class, 'index'])->name('class.index');
        Route::get('/create', [ClassTypeController::class, 'create'])->name('class.create');
        Route::post('/store', [ClassTypeController::class, 'store'])->name('class.store');
        Route::get('/edit/{id}', [ClassTypeController::class, 'edit'])->name('class.edit');
        Route::post('/update/{id}', [ClassTypeController::class, 'update'])->name('class.update');
        Route::get('/delete/{id}', [ClassTypeController::class, 'destroy'])->name('class.destroy');
    });

    //Students Management 
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/create', [StudentController::class, 'create'])->name('student.create');
        Route::post('/store', [StudentController::class, 'store'])->name('student.store');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
        Route::put('/update/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    });

    //Book 
    Route::prefix('books')->group(function () {
        Route::get('', [BookController::class, 'index'])->name('books.index');
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::get('/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/{id}', [BookController::class, 'destroy'])->name('books.destroy');
        Route::get('/sell', [BookController::class, 'sellForm'])->name('books.sellForm');
        Route::post('/add-to-session', [BookController::class, 'addToSession'])->name('books.addToSession');
        Route::post('/sell', [BookController::class, 'sell'])->name('books.sell');
        Route::post('/sell/clear', [BookController::class, 'clearCart'])->name('books.clearCart');
        Route::get('/sell/remove/{index}', [BookController::class, 'removeFromSession'])->name('books.removeFromSession');
        Route::get('/sell-history', [BookController::class, 'sellHistory'])->name('books.sellHistory');
    });

    //Expense
    Route::resource('expenses', ExpenseController::class);
});


require __DIR__ . '/auth.php';
