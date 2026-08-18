<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Follow;
use App\Models\Article;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Follow::class;

    public function definition()
    {
        $followableType = $this->faker->randomElement([User::class, Article::class]);
        $followable = $followableType::factory()->create();

        return [
            'user_id' => User::factory(),
            'followable_id' => $followable->id,
            'followable_type' => $followableType,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
