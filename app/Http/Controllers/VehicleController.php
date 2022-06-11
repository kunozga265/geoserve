<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user=(new AppController())->getAuthUser($request);

        if($user->hasRole('management') || $user->hasRole('administrator')){
            $vehicles= Vehicle::orderBy('vehicleRegistrationNumber','asc')->get();
        }else
            $vehicles= Vehicle::orderBy('vehicleRegistrationNumber','asc')->where('verified',1)->get();



        return response()->json(VehicleResource::collection($vehicles));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            "vehicleRegistrationNumber" =>  ['required','unique:vehicles'],
            "mileage"                   =>  ['required'],
        ]);

        $vehicle=Vehicle::create([
            "photo"                         =>  $request->photo,
            "vehicleRegistrationNumber"     =>  $request->vehicleRegistrationNumber,
            "mileage"                       =>  $request->mileage,
            "lastRefillDate"                =>  $request->lastRefillDate,
            "lastRefillFuelReceived"        =>  $request->lastRefillFuelReceived,
            "lastRefillMileageCovered"      =>  $request->lastRefillMileageCovered,
            "verified"                      =>  false,
        ]);

        return response()->json(new VehicleResource($vehicle),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle))
            return response()->json(new VehicleResource($vehicle));
        else
            return response()->json(['message'=>'Vehicle not found'],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle)){

            if($vehicle->verified)
                return response()->json(['message'=>'Vehicle is not editable'],404);

            $request->validate([
                "vehicleRegistrationNumber" =>  ['required'],
                "mileage"                   =>  ['required'],
            ]);

            $vehicle->update([
                "photo"                         =>  $request->photo,
                "vehicleRegistrationNumber"     =>  $request->vehicleRegistrationNumber,
                "mileage"                       =>  $request->mileage,
                "lastRefillDate"                =>  $request->lastRefillDate,
                "lastRefillFuelReceived"        =>  $request->lastRefillFuelReceived,
                "lastRefillMileageCovered"      =>  $request->lastRefillMileageCovered,
            ]);

            return response()->json(new VehicleResource($vehicle));
        }
        else
            return response()->json(['message'=>'Vehicle not found'],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request, $id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle)){

            $vehicle->update([
                "verified"  =>  true,
            ]);

            return response()->json(new VehicleResource($vehicle));
        }
        else
            return response()->json(['message'=>'Vehicle not found'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle)){

            if($vehicle->verified)
                return response()->json(['message'=>'Vehicle cannot be deleted'],404);

            $vehicle->delete();

            return response()->json(['message'=>'Vehicle has been deleted']);

        } else
            return response()->json(['message'=>'Vehicle not found'],404);
    }
}
