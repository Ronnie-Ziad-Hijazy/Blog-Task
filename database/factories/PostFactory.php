<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence() . ' ' . rand(1,20000),
            'content' => fake()->paragraph(5),
            'author' => fake()->name(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
