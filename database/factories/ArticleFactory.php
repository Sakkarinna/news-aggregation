<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Article::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'pic_url' => $this->faker->boolean(70) // 70% chance to have an image URL
                ? $this->faker->imageUrl(640, 480, 'news', true, 'Article Image')
                : null,
            'vid_url' => $this->faker->boolean(50) // 50% chance to have a video URL
                ? $this->faker->randomElement([
                    'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'https://www.youtube.com/watch?v=3JZ_D3ELwOQ',
                    'https://vimeo.com/148751763',
                    'https://vimeo.com/65855332',
                ])
                : null,
        ];
    }



}
