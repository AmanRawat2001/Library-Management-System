<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BookTransactionService
{
    public function borrowBook(Book $book)
    {
        if ($book->stock > 0) {
            $book->decrement('stock');
            Auth::user()->books()->attach($book->id, [
                'status' => 'borrowed',
                'borrowed_at' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(10),
            ]);

            return ['success' => 'Book successfully booked.'];
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
                $book->decrement('stock');
                $reservation->user->books()->attach($book->id, [
                    'status' => 'borrowed',
                    'borrowed_at' => Carbon::now(),
                    'due_date' => Carbon::now()->addDays(10),
                ]);
                $reservation->delete();

                return ['success' => "Book returned and assigned to {$reservation->user->name}."];
            }

            return ['success' => 'Book returned successfully.'];
        }

        return ['error' => 'You did not borrow this book.'];
    }
}
