<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookTransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('books', BookController::class);
    Route::post('/books/{book}/borrow', [BookTransactionController::class, 'borrowBook'])->name('books.book');
    Route::post('/books/{book}/reserve', [BookTransactionController::class, 'reserveBook'])->name('books.reserve');
    Route::post('/books/{book}/return', [BookTransactionController::class, 'returnBook'])->name('books.return');
    Route::resource('categories', CategoryController::class);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

});

require __DIR__.'/auth.php';
