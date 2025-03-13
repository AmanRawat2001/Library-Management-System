<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'category_id', 'stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('status', 'due_date', 'return_requested_at', 'requested_at', 'borrowed_at', 'returned_at');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function bookUsers()
    {
        return $this->hasMany(BookUser::class);
    }
}
