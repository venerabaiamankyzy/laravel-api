<?php

namespace Database\Seeders;

use App\Models\Project;

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
        for($i = 0; $i < 40; $i++) {
            $project = new Project;
            $project->title = $faker->catchPhrase(2);
            $project->slug = Str::of($project->title)->slug('-');
            // $project->image = "https://picsum.photos/200/300";
            $project->text = $faker->text(90);
            $project->link = $faker->url();
            $project->save();

        }
        
    }
}