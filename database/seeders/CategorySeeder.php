<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Horror',

            ],
            [
                'name' => 'Adventure stories',
            ],
            [
                'name' => 'Science fiction',
            ],
            [
                'name' => 'Mystery',
            ],
            [
                'name' => 'Fantasy',
            ],
            [
                'name' => 'Romance',
            ],
            [
                'name' => 'Dystopian',
            ],
            [
                'name' => 'Contemporary',
            ],
        ];

        Category::insert($data);
    }
}
