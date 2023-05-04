<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;

// Importiamo Generator as Faker
use Faker\Generator as Faker;

// Importiamo per lo SLUG
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {   
         $types = Type::all()->pluck('id');

        for($i = 0; $i < 40; $i++) {
            $project = new Project;
            $project->type_id = $faker->randomElement($types);
            $project->title = $faker->catchPhrase();
            $project->slug = Str::of($project->title)->slug('-');
            // $project->image = "https://picsum.photos/200/300";
            $project->text = $faker->text(90);
            $project->link = $faker->url();
            $project->save();

        }
        
    }
}