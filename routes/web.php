<?php

use App\Http\Controllers\ClassTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

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
        Route::post('/update/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::get('/delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    });

});


require __DIR__.'/auth.php';
