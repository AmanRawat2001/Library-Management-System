<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $authors = [];
        if (empty($authors)) {
            $authors = collect(range(1, 3))->map(fn () => fake()->name())->toArray();
        }

        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->randomElement($authors),
            'stock' => $this->faker->numberBetween(1, 5),
            'category_id' => Category::inRandomOrder()->first()->id,

        ];
    }
}
