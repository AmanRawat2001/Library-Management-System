<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\Reservation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'visitor')->count();
        $pending = BookUser::where('status', 'pending')->count();
        $borrowed = BookUser::where('status', 'borrowed')->count();
        $returned = BookUser::where('status', 'returned')->count();
        $pendingReturn = BookUser::where('status', 'pending_return')->count();
        $pendingReservation = Reservation::where('status', 'pending')->count();
        $reserved = Reservation::where('status', 'reserved')->count();
        $topBooks = BookUser::topBook()->with('book:id,title')->get();
        $topReaders = BookUser::topReader()->with('user:id,name')->get();

        return view('dashboard', compact(
            'totalBooks', 'totalUsers', 'pending', 'borrowed',
            'returned', 'pendingReturn', 'pendingReservation', 'reserved',
            'topBooks', 'topReaders'
        ));
    }
}
