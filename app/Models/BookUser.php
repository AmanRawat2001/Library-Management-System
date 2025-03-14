<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookUser extends Model
{
    use HasFactory;

    protected $table = 'book_user';

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'due_date',
        'requested_at',
        'borrowed_at',
        'returned_at',
        'return_requested_at',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
        'return_requested_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopePendingReturns($query)
    {
        return $query->where('status', 'pending_return') ->with(['book', 'user'])->latest();
    }

    public function scopePendingBorrowRequests($query)
    {
        return $query->where('status', 'pending')->with(['book', 'user'])->latest();
    }

    public static function topReader()
    {
        return self::select('user_id', DB::raw('COUNT(book_id) as books_read'))
            ->where('status', '!=', 'pending')
            ->groupBy('user_id')
            ->orderBy('books_read', 'DESC')
            ->limit(10);
    }

    public static function topBook()
    {
        return self::select('book_id', DB::raw('COUNT(user_id) as times_read'))
            ->where('status', '!=', 'pending')
            ->groupBy('book_id')
            ->orderBy('times_read', 'DESC')
            ->limit(10);
    }
}
