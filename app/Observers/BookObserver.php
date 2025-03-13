<?php

namespace App\Observers;

use App\Helpers\NotificationHelper;
use App\Models\Book;

class BookObserver
{
    public function updated(Book $book)
    {
        if ($book->stock == 0) {
            NotificationHelper::notifyAdmin("Book '{$book->title}' is out of stock.");
        }
    }
}
