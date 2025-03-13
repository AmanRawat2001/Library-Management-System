<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use App\Services\BookTransactionService;

class BookTransactionController extends Controller
{
    protected $bookTransactionService;

    public function __construct(BookTransactionService $bookTransactionService)
    {
        $this->bookTransactionService = $bookTransactionService;
    }

    public function borrowRequests()
    {
        $borrowRequests = $this->bookTransactionService->getBorrowRequests();

        return view('admin.borrow_requests', compact('borrowRequests'));
    }

    public function returnRequests()
    {
        $returnRequests = $this->bookTransactionService->getReturnRequests();

        return view('admin.return_requests', compact('returnRequests'));
    }

    public function borrowBook(Book $book)
    {
        $result = $this->bookTransactionService->borrowBook($book);

        return redirect()->back()->with(key($result), reset($result));
    }

    public function reserveBook(Book $book)
    {
        $result = $this->bookTransactionService->reserveBook($book);

        return redirect()->back()->with(key($result), reset($result));
    }

    public function cancelReservation(Reservation $reservation)
    {
        $result = $this->bookTransactionService->cancelReservation($reservation);

        return redirect()->back()->with(key($result), reset($result));
    }

    public function returnBook(Book $book)
    {
        $result = $this->bookTransactionService->returnBook($book);

        return redirect()->back()->with(key($result), reset($result));
    }

    public function approveBorrowRequest(Book $book, User $user)
    {
        $result = $this->bookTransactionService->approveBorrowRequest($book, $user);

        return redirect()->back()->with(key($result), reset($result));
    }

    public function denyBorrowRequest(Book $book, User $user)
    {
        $result = $this->bookTransactionService->denyBorrowRequest($book, $user);

        return redirect()->back()->with(key($result), reset($result));
    }

    public function approveReturnRequest(Book $book, User $user)
    {
        $result = $this->bookTransactionService->approveReturnRequest($book, $user);

        return redirect()->back()->with(key($result), reset($result));
    }

    public function denyReturnRequest(Book $book, User $user)
    {
        $result = $this->bookTransactionService->denyReturnRequest($book, $user);

        return redirect()->back()->with(key($result), reset($result));
    }

    public function borrowedBooks()
    {
        $borrowedBooks = $this->bookTransactionService->getBooks();

        return view('visitor.borrowed-books', compact('borrowedBooks'));
    }

    public function reservedBooks()
    {
        $reservedBooks = $this->bookTransactionService->getReservedBooks();

        return view('visitor.reserved-books', compact('reservedBooks'));
    }
}
