<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookTransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', fn () => redirect('login'));

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('books', BookController::class);

    Route::post('/books/{book}/borrow', [BookTransactionController::class, 'borrowBook'])->name('books.book');
    Route::post('/books/{book}/reserve', [BookTransactionController::class, 'reserveBook'])->name('books.reserve');
    Route::delete('/books/cancel-reservation/{reservation}', [BookTransactionController::class, 'cancelReservation'])->name('books.cancel');
    Route::post('/books/{book}/return', [BookTransactionController::class, 'returnBook'])->name('books.return');
    Route::get('borrowed_books', [BookTransactionController::class, 'borrowedBooks'])->name('borrowed_books');
    Route::get('reserved_books', [BookTransactionController::class, 'reservedBooks'])->name('reserved_books');

    Route::resource('notifications', NotificationController::class)->only(['index']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::middleware('role:admin')->group(function () {
        Route::get('/borrow-requests', [BookTransactionController::class, 'borrowRequests'])->name('borrow_requests');
        Route::get('/return-requests', [BookTransactionController::class, 'returnRequests'])->name('return_requests');
        Route::post('/books/{book}/approve/{user}', [BookTransactionController::class, 'approveBorrowRequest'])->name('books.approve');
        Route::post('/books/{book}/deny/{user}', [BookTransactionController::class, 'denyBorrowRequest'])->name('books.deny');
        Route::post('/books/{book}/return/approve/{user}', [BookTransactionController::class, 'approveReturnRequest'])->name('return.approve');
        Route::post('/books/{book}/return/deny/{user}', [BookTransactionController::class, 'denyReturnRequest'])->name('return.deny');
        Route::resource('categories', CategoryController::class);

    });
});

require __DIR__.'/auth.php';
