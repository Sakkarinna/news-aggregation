<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Like;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition()
    {
        // Randomly select the likeable model (either Article or Comment)
        $likeableType = $this->faker->randomElement([Article::class, Comment::class]);
        $likeable = $likeableType::inRandomOrder()->first();

        // Ensure that there is at least one likeable model available
        if (!$likeable) {
            $likeable = $likeableType::factory()->create();
        }

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'likeable_id' => $likeable->id,
            'likeable_type' => $likeableType,
        ];
    }
}
