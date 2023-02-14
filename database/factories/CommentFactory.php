<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'post_id' => function() {
                if(!empty(\App\Models\Post::all())){
                    return \App\Models\Post::all()->random();
                }else{
                    return null;
                }
            },
            'author' => fake()->name,
            'comment' => fake()->sentence,
            'vote' => fake()->numberBetween(0,1)
        ];
    }
}
