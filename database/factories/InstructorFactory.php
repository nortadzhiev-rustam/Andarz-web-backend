<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class InstructorFactory extends Factory {
    public function definition(): array {
        return ['name' => $this->faker->name(), 'avatar' => '', 'bio' => $this->faker->paragraph()];
    }
}
