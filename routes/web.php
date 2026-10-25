<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
    return "about";
})->name('about');  

Route::get('/contact', function () {
    return "contact";
})->name('contact'); 

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::middleware('role:admin')->get('/admin', [App\Http\Controllers\HomeController::class, 'admin'])
        ->name('dashboard.admin');

    Route::middleware('role:admin,supervisor')->get('/supervisor', [App\Http\Controllers\HomeController::class, 'supervisor'])
        ->name('dashboard.supervisor');

    Route::middleware('role:employee')->get('/employee', [App\Http\Controllers\HomeController::class, 'employee'])
        ->name('dashboard.employee');
});
