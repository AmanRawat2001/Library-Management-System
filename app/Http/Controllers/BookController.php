<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        // only allow admin roles
        $this->middleware('role:admin')->only('create', 'store', 'destroy', 'updated', 'edit');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Book::query();
        $books = $query->when($search, function ($query) use ($search) {
            return $query->where('author', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('books.index', compact('books', 'search'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('books.create', compact('categories'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function store(StoreBookRequest $request)
    {
        Book::create($request->validated());

        return redirect()->route('books.index')->with('success', 'Book created successfully');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();

        return view('books.edit', compact('book', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $previousStock = $book->stock;
        $book->update($request->validated());
        if ($previousStock == 0 && $book->stock > 0) {
            $this->assignReservedBooks($book);
        }

        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }

    private function assignReservedBooks(Book $book)
    {
        $reservations = $book->reservations()->where('status', 'pending')->orderBy('created_at', 'asc')->get();

        foreach ($reservations as $reservation) {
            if ($book->stock > 0) {
                $reservation->user->books()->attach($book->id, [
                    'status' => 'pending',
                    'requested_at' => Carbon::now(),
                ]);
                NotificationHelper::notifyAdmin("{$reservation->user->name} has been assigned the book {$book->title}");
                $reservation->update(['status' => 'reserved']);
            } else {
                break;
            }
        }
    }
}
