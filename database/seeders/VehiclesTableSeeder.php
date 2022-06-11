<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::create([
           'vehicleRegistrationNumber'      =>  "MZ 6890",
           'mileage'                        =>  75800,
            'verified'   =>  false,
        ]);
        Vehicle::create([
           'vehicleRegistrationNumber'      =>  "MZ 10178",
           'mileage'                        =>  75800,
            'verified'   =>  false,
        ]);
        Vehicle::create([
           'vehicleRegistrationNumber'      =>  "BZ 657",
           'mileage'                        =>  3000,
            'verified'   =>  false,
        ]);
    }
}
