<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class QuoteFactory extends Factory {
    public function definition(): array {
        return ['content'=>$this->faker->paragraph(),'translation'=>null,'language'=>'fa','author_id'=>null,'category_id'=>null,'user_id'=>null,'is_featured'=>false,'is_active'=>true];
    }
}
