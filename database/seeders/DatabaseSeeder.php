<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(GradesTableSeeder::class);
         $this->call(RoleTableSeeder::class);
         $this->call(PositionTableSeeder::class);
//         $this->call(ProjectsTableSeeder::class);
//         $this->call(VehiclesTableSeeder::class);

         $this->call(UserTableSeeder::class);
//        \App\Models\User::factory(21)->create();
    }
}
