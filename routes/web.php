<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/strona', function () {
    return view('strona');
});

Route::get('/books/create', [BookController::class, 'create'])
    ->name('books.create');

Route::post('/books', [BookController::class, 'store'])
    ->name('books.store');

Route::get('/books', [BookController::class, 'index'])
    ->name('books.index');

Route::get('/about', function () {
    return 'about';
})->name('about');

Route::get('/contact', function () {
    return 'contact';
})->name('contact');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware('role:admin')->get('/admin', [HomeController::class, 'admin'])
        ->name('dashboard.admin');

    Route::middleware('role:admin,supervisor')->get('/supervisor', [HomeController::class, 'supervisor'])
        ->name('dashboard.supervisor');

    Route::middleware('role:employee')->get('/employee', [HomeController::class, 'employee'])
        ->name('dashboard.employee');

    Route::post('/admin/users', [UserController::class, 'store'])
        ->middleware('role:admin')
        ->name('users.store');
    Route::post('/admin/users/delete', [UserController::class, 'destroy' ])
        ->middleware('role:admin')
        ->name('users.destroy');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('role:admin')
        ->name('users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])
        ->middleware('role:admin')
        ->name('users.update');
});

/*
//use App\Http\Controllers\UserController;
use App\Models\User;

// Route definition...
Route::get('/users/{user}', [UserController::class, 'show']);

// Controller method definition...
public function show(User $user)
{
    return view('user.profile', ['user' => $user]);
}
    */