<?php
namespace Database\Seeders;
use App\Models\Author;
use App\Models\Category;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::factory()->create(['name'=>'Admin','email'=>'admin@andarz.test','password'=>Hash::make('password'),'role'=>'admin']);
        User::factory()->create(['name'=>'Demo User','email'=>'user@andarz.test','password'=>Hash::make('password'),'role'=>'user']);
        foreach ([['name'=>'Wisdom','slug'=>'wisdom'],['name'=>'Love','slug'=>'love'],['name'=>'Life','slug'=>'life'],['name'=>'Philosophy','slug'=>'philosophy']] as $c) {
            Category::create(array_merge($c,['is_active'=>true]));
        }
        foreach ([['name'=>'Rumi','slug'=>'rumi','bio'=>'13th-century Persian poet.'],['name'=>'Hafez','slug'=>'hafez','bio'=>'Persian lyric poet.'],['name'=>'Saadi','slug'=>'saadi','bio'=>'Persian poet.']] as $a) {
            Author::create(array_merge($a,['is_active'=>true]));
        }
        Quote::factory()->count(20)->create(['is_active'=>true]);
        Quote::factory()->count(5)->create(['is_active'=>true,'is_featured'=>true]);
    }
}
