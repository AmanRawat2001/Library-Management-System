<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['pending', 'reserved', 'cancelled'];

        // Create 20 dummy reservations
        for ($i = 0; $i < 20; $i++) {
            $visitor = User::where('role', 'visitor')->inRandomOrder()->first();

            if ($visitor) {
                Reservation::create([
                    'user_id' => $visitor->id,
                    'book_id' => Book::inRandomOrder()->first()->id,
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}
