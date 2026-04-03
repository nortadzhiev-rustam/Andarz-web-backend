<?php
namespace Database\Factories;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class CourseFactory extends Factory {
    public function definition(): array {
        $title = $this->faker->sentence(4);
        return [
            'title'             => $title,
            'slug'              => Str::slug($title),
            'description'       => $this->faker->paragraph(3),
            'short_description' => $this->faker->sentence(),
            'thumbnail'         => '',
            'price'             => $this->faker->randomFloat(2, 9, 99),
            'discount_price'    => null,
            'level'             => $this->faker->randomElement(['beginner','intermediate','advanced']),
            'category'          => $this->faker->randomElement(['Web Development','Backend Development','Data Science','Design']),
            'tags'              => [],
            'instructor_id'     => Instructor::factory(),
            'duration'          => $this->faker->randomElement(['8 hours','12 hours','16 hours','20 hours']),
            'students_count'    => $this->faker->numberBetween(100, 5000),
            'rating'            => $this->faker->randomFloat(1, 3.5, 5.0),
            'reviews_count'     => $this->faker->numberBetween(10, 500),
            'language'          => 'English',
            'last_updated'      => now()->format('Y-m-d'),
            'is_published'      => true,
            'is_featured'       => false,
        ];
    }
}
