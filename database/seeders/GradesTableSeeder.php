<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grade::create([
            "title" =>  "Directors",
            "code"  =>  "E"
        ]);
        Grade::create([
           "title"=>"Managers",
            "code"  =>  "D"
        ]);
        Grade::create([
           "title"=>"Executives",
            "code"  =>  "C"
        ]);
        Grade::create([
           "title"=>"Supervisors",
            "code"  =>  "B"
        ]);
        Grade::create([
           "title"=>"General Employees and Artisans",
            "code"  =>  "A"
        ]);
        Grade::create([
           "title"=>"Drilling Supervisor",
            "code"  =>  "DC"
        ]);
        Grade::create([
           "title"=>"Drillers and Drivers",
            "code"  =>  "DB"
        ]);
        Grade::create([
           "title"=>"Drilling Assistants",
            "code"  =>  "DA"
        ]);
    }
}
