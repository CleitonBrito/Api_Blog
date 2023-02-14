<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

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
    public function definition()
    {
        return [
            'user_id' => function (){
                if(!empty(\App\Models\User::all()))
                    return \App\Models\User::all()->random();
                else
                    return null;
            },
            'title' => fake()->sentence,
            'slug' => fake()->slug,
            'content' => fake()->paragraph,
        ];
    }
}
