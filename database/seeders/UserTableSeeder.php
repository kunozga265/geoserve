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
           'firstName'      =>  'Pilirani',
           'middleName'     =>  'Joel',
           'lastName'       =>  'Nyemba',
           'email'          =>  'pjn@geoserve.com',
           'position_id'    =>  1,
           'password'       =>  bcrypt('12345678'),
        ]);
        $user->roles()->attach([1]);
    }
}
