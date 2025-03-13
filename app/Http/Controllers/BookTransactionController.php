<?php

namespace App\Http\Controllers;

use App\Models\Book;
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

        return view('borrow_requests', compact('borrowRequests'));
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
}
