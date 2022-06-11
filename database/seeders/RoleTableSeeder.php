<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            "name"=>"management"
        ]);

        Role::create([
            "name"=>"administrator"
        ]);

        Role::create([
            "name"=>"accountant"
        ]);

        Role::create([
            "name"=>"employee"
        ]);

        Role::create([
            "name"=>"unverified"
        ]);
    }
}
