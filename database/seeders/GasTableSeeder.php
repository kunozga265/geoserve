<?php

namespace Database\Seeders;

use App\Models\Gas;
use Illuminate\Database\Seeder;

class GasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gas::create([
            'type'      => 'Petrol',
            'perLitre'  => 1890,
        ]);

        Gas::create([
            'type'      => 'Diesel',
            'perLitre'  => 2000,
        ]);
    }
}
