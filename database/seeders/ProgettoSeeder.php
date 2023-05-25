<?php

namespace Database\Seeders;

use App\Models\Progetto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProgettoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $newProgetto = new Progetto();
            $newProgetto->title = $faker->sentence(4);
            $newProgetto->content = $faker->text(500);
            $newProgetto->slug = Str::slug($newProgetto->title, '-');
            $newProgetto->save(); 
        }
    }
}