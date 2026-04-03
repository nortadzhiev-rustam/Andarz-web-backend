<?php
namespace Database\Factories;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class BlogPostFactory extends Factory {
    public function definition(): array {
        $title = $this->faker->sentence(6);
        return [
            'title'        => $title,
            'slug'         => Str::slug($title),
            'excerpt'      => $this->faker->sentence(20),
            'content'      => $this->faker->paragraphs(5, true),
            'thumbnail'    => '',
            'author_id'    => Instructor::factory(),
            'tags'         => [],
            'category'     => $this->faker->randomElement(['Technology','Learning','Education','Design']),
            'published_at' => now()->format('Y-m-d'),
            'reading_time' => $this->faker->randomElement(['3 min read','5 min read','7 min read']),
            'is_published' => true,
        ];
    }
}
