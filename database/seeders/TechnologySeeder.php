<?php

namespace Database\Seeders;

use App\Models\Technology;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $labels = ["HTML", "CSS", "JavaScript", "PHP", "GIT", "Blade", "SQL"];
         
        foreach($labels as $label) {
            $type = new Technology();
            $type->label = $label;
            $type->color = $faker->hexColor();
            $type->save();

        }
    }
}