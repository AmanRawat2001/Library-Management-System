<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isVisitor()) {
            $userId = Auth::id();
            $userBooksCount = BookUser::where('user_id', $userId)->count();
            $borrowed = BookUser::where('user_id', $userId)->where('status', 'borrowed')->count();
            $returned = BookUser::where('user_id', $userId)->where('status', 'returned')->count();
            $pendingReturn = BookUser::where('user_id', $userId)->where('status', 'pending_return')->count();
            $pendingReservation = Reservation::where('user_id', $userId)->where('status', 'pending')->count();
            $reserved = Reservation::where('user_id', $userId)->where('status', 'reserved')->count();

            // Initialize admin-related variables to avoid "undefined variable" errors
            $totalBooks = null;
            $totalUsers = null;
            $topBooks = null;
            $topReaders = null;
            $pending = null;
        } else {
            $totalBooks = Book::count();
            $totalUsers = User::where('role', 'visitor')->count();
            $pending = BookUser::where('status', 'pending')->count();
            $borrowed = BookUser::where('status', 'borrowed')->count();
            $returned = BookUser::where('status', 'returned')->count();
            $pendingReturn = BookUser::where('status', 'pending_return')->count();
            $pendingReservation = Reservation::where('status', 'pending')->count();
            $reserved = Reservation::where('status', 'reserved')->count();

            // Fetch top books and top readers
            $topBooks = BookUser::topBook()->with('book:id,title')->get();
            $topReaders = BookUser::topReader()->with('user:id,name')->get();
        }

        return view('dashboard', compact(
            'totalBooks',
            'totalUsers',
            'pending',
            'borrowed',
            'returned',
            'pendingReturn',
            'pendingReservation',
            'reserved',
            'topBooks',
            'topReaders',
            'userBooksCount'
        ));
    }
}
