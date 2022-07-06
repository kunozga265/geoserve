<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Models\Gas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GasController extends Controller
{
    public function edit()
    {
        $petrol=Gas::where('type','Petrol')->first();
        $diesel=Gas::where('type','Diesel')->first();

        return Inertia::render('Vehicles/FuelPrices',[
            'petrol'    => $petrol->perLitre,
            'diesel'   => $diesel->perLitre,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
           'petrol' => ['required','numeric'],
           'diesel' => ['required','numeric'],
        ]);

        $petrol=Gas::where('type','Petrol')->first();
        $petrol->update([
           'perLitre' => $request->petrol
        ]);

        $diesel=Gas::where('type','Diesel')->first();
        $diesel->update([
            'perLitre' => $request->diesel
        ]);

        if ((new AppController())->isApi($request)) {
            //API Response
            return response()->json(['message' => 'Fuel prices edited']);
        }else{
            //Web Response
            return Redirect::route('vehicles')->with('success','Fuel prices edited');
        }



    }
}
