<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('strona');
});

Route::get('/strona', function () {
    return view('strona');
}); 

Route::get('/books/create', [BookController::class, 'create']) 
->name('books.create');

Route::post('/books', [BookController::class, 'store'])
->name('books.store');

Route::get('/books', [BookController::class, 'index'])
 ->name('books.index');

Route::get('/home', function () {
    return "home";
})->name('home');

Route::get('/about', function () {
    return "about";
})->name('about');  

Route::get('/contact', function () {
    return "contact";
})->name('contact'); 

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
