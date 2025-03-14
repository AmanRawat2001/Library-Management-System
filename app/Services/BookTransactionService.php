<?php

namespace App\Services;

use App\Helpers\NotificationHelper;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\BorrowRequestNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
                'created_at' => Carbon::now(),
            ]);
            // Notify admin
            NotificationHelper::notifyAdmin('User '.Auth::user()->name." has requested to borrow '{$book->title}'.");

            return ['success' => 'Book successfully booked. Please wait for approval.'];
        }

        return ['error' => 'Book is out of stock.'];
    }

    public function reserveBook(Book $book)
    {
        $existingReservation = Reservation::where('user_id', Auth::user()->id)
            ->where('book_id', $book->id)
            ->where('status', 'pending')
            ->exists();

        if ($existingReservation) {
            return ['error' => 'You have already reserved this book.'];
        }

        if ($book->stock == 0) {
            Reservation::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'status' => 'pending',
            ]);

            NotificationHelper::notifyAdmin('User '.Auth::user()->name." has reserved '{$book->title}'.");

            return ['success' => 'Book reserved successfully.'];
        }

        return ['error' => 'This book is available. You can book it instead.'];
    }

    public function cancelReservation(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $reservation->update(['status' => 'cancelled']);

        return ['success' => 'Reservation canceled successfully.'];
    }

    public function returnBook(Book $book)
    {
        $borrowed = Auth::user()->books()->where('book_id', $book->id)->wherePivot('status', 'borrowed')->first();

        if ($borrowed) {
            $book->increment('stock');
            Auth::user()->books()->updateExistingPivot($book->id, [
                'status' => 'pending_return',
                'return_requested_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            NotificationHelper::notifyAdmin('User '.Auth::user()->name." has requested to return '{$book->title}'. Please review.");

            return ['success' => 'Book returned successfully and pending approval.'];
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
                'updated_at' => Carbon::now(),
            ]);
            $user->notify(new BorrowRequestNotification('approved', $book->title));
            NotificationHelper::notifyAdmin("User {$user->name} has borrowed '{$book->title}'.");

            return ['success' => 'Borrow request approved.'];
        }

        return ['error' => 'Book is out of stock.'];
    }

    public function denyBorrowRequest(Book $book, User $user)
    {
        $user->books()->detach($book->id);
        $user->notify(new BorrowRequestNotification('denied', $book->title));
        NotificationHelper::notifyAdmin("Borrow request for '{$book->title}' by {$user->name} has been denied.");
        $reservation = Reservation::where('book_id', $book->id)->where('status', 'pending')->orderBy('created_at', 'asc')->first();

        if ($reservation) {
            $reservation->user->books()->attach($book->id, [
                'status' => 'pending',
                'requested_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]);

            $reservation->update(['status' => 'reserved']);

            NotificationHelper::notifyAdmin("User {$reservation->user->name} has been assigned '{$book->title}'.");

            return ['success' => 'Book returned successfully and assigned to the next user.'];
        }

        return ['success' => 'Borrow request denied.'];
    }

    public function approveReturnRequest(Book $book, User $user)
    {
        $returnRequest = $user->books()->where('book_id', $book->id)->wherePivot('status', 'pending_return')->first();

        if ($returnRequest) {
            $book->increment('stock');
            $user->books()->updateExistingPivot($book->id, [
                'status' => 'returned',
                'returned_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            NotificationHelper::notifyAdmin("User {$user->name} has returned '{$book->title}'.");
            $user->notify(new BorrowRequestNotification('approved', $book->title));

            $reservation = Reservation::where('book_id', $book->id)->where('status', 'pending')->orderBy('created_at', 'asc')->first();

            if ($reservation) {
                $reservation->user->books()->attach($book->id, [
                    'status' => 'pending',
                    'requested_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]);

                $reservation->update(['status' => 'reserved']);

                NotificationHelper::notifyAdmin("User {$reservation->user->name} has been assigned '{$book->title}'.");

                return ['success' => 'Book returned successfully and assigned to the next user.'];
            }

            return ['success' => 'Return request approved.'];
        }

        return ['error' => 'Return request denied.'];
    }

    public function denyReturnRequest(Book $book, User $user)
    {
        $user->books()->updateExistingPivot($book->id, ['status' => 'borrowed']);
        $user->notify(new BorrowRequestNotification('denied', $book->title));
        NotificationHelper::notifyAdmin("Return request for '{$book->title}' by {$user->name} has been denied.");

        return ['success' => 'Return request denied.'];
    }

    public function getReturnRequests()
    {
        return BookUser::pendingReturns()->paginate(10);
    }

    public function getBorrowRequests()
    {

        return BookUser::pendingBorrowRequests()->paginate(10);
    }

    public function getUserBooks()
    {
        return Auth::user()->books()->paginate(10);
    }

    public function getUserReservedBooks()
    {
        return Auth::user()->reservations()->paginate(10);
    }
}
