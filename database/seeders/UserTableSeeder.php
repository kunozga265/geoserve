<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
           'firstName'      =>  'Kunozga',
           'middleName'     =>  'Dee',
           'lastName'       =>  'Mlowoka',
           'email'          =>  'kunozgamlowoka@gmail.com',
           'position_id'    =>  1,
           'password'       =>  bcrypt('12345678'),
        ]);
        $user->roles()->attach([1]);

        $user=User::create([
           'firstName'      =>  'Gehazi',
           'middleName'     =>  null,
           'lastName'       =>  'Jenda',
           'email'          =>  'kunozmlowoka@gmail.com',
           'position_id'    =>  7,
           'password'       =>  bcrypt('12345678'),
        ]);
        $user->roles()->attach([1]);

    }
}
