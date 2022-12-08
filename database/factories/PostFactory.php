<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name();
        return [
            'post_title' => $name,
            'post_content' => fake()->realText(),
            'post_image' => 'images/logo.webp',
            'post_slug' => Str::slug($name),
            'author_id' => 1
        ];
    }
}
