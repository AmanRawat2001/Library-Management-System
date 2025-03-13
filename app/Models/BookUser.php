<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $query->where('status', 'pending_return')
            ->with(['book', 'user']);
    }

    public function scopePendingBorrowRequests($query)
    {
        return $query->where('status', 'pending')->with(['book', 'user']);
    }
}
