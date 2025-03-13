<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\BorrowRequestNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookTransactionService
{
    public function borrowBook(Book $book)
    {
        $alreadyBorrowed = Auth::user()->books()->where('book_id', $book->id)->wherePivotIn('status', ['borrowed', 'pending'])->exists();

        if ($alreadyBorrowed) {
            return ['error' => 'You can only borrow one book at a time. Please return your current book first.'];
        }
        if ($book->stock > 0) {
            Auth::user()->books()->attach($book->id, [
                'status' => 'pending',
                'requested_at' => Carbon::now(),
            ]);

            return ['success' => 'Book successfully booked. Please wait for approval.'];
        }

        return ['error' => 'Book is out of stock.'];
    }

    public function reserveBook(Book $book)
    {
        $existingReservation = Reservation::where('user_id', Auth::user()->id)
            ->where('book_id', $book->id)
            ->where('status', 'reserved')
            ->exists();

        if ($existingReservation) {
            return ['error' => 'You have already reserved this book.'];
        }

        if ($book->stock == 0) {
            Reservation::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'status' => 'reserved',
            ]);

            return ['success' => 'Book reserved successfully.'];
        }

        return ['error' => 'This book is available. You can book it instead.'];
    }

    public function returnBook(Book $book)
    {
        $borrowed = Auth::user()->books()->where('book_id', $book->id)->wherePivot('status', 'borrowed')->first();

        if ($borrowed) {
            $book->increment('stock');
            Auth::user()->books()->updateExistingPivot($book->id, [
                'status' => 'returned',
                'returned_at' => Carbon::now(),
            ]);
            $reservation = Reservation::where('book_id', $book->id)->where('status', 'reserved')->orderBy('created_at', 'asc')->first();

            if ($reservation) {
                $reservation->user->books()->attach($book->id, [
                    'status' => 'pending',
                    'requested_at' => Carbon::now(),
                ]);
                $reservation->delete();

                return ['success' => "Book returned and assigned to {$reservation->user->name}."];
            }

            return ['success' => 'Book returned successfully.'];
        }

        return ['error' => 'You did not borrow this book.'];
    }

    public function approveBorrowRequest(Book $book, User $user)
    {
        $borrowRequest = $user->books()->where('book_id', $book->id)->wherePivot('status', 'pending')->first();

        if ($borrowRequest && $book->stock > 0) {
            $book->decrement('stock');

            $user->books()->updateExistingPivot($book->id, [
                'status' => 'borrowed',
                'borrowed_at' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(10),
            ]);
            $user->notify(new BorrowRequestNotification('approved', $book->title));

            return redirect()->back()->with('success', 'Borrow request approved.');
        }

        return redirect()->back()->with('error', 'Book is out of stock.');
    }

    public function denyBorrowRequest(Book $book, User $user)
    {
        $user->books()->detach($book->id);
        $user->notify(new BorrowRequestNotification('denied', $book->title));

        return redirect()->back()->with('success', 'Borrow request denied.');
    }

    public function getBorrowRequests()
    {
        return DB::table('book_user')->where('status', 'pending')
            ->join('books', 'book_user.book_id', '=', 'books.id')
            ->join('users', 'book_user.user_id', '=', 'users.id')
            ->select('book_user.*', 'books.title', 'users.name', 'users.id as user_id')
            ->get();
    }
}
