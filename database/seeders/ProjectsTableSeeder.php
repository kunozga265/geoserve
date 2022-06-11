<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
           'name'       =>  'Project 1',
           'client'     =>  'Client 1',
           'site'       =>  'Site Location 1',
           'verified'   =>  false,

        ]);

        Project::create([
           'name'       =>  'Project 2',
           'client'     =>  'Client 2',
           'site'       =>  'Site Location 2',
            'verified'   =>  false,
        ]);

        Project::create([
           'name'       =>  'Project 3',
           'client'     =>  'Client 3',
           'site'       =>  'Site Location 3',
            'verified'   =>  false,
        ]);
    }
}
