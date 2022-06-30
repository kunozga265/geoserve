<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user=(new AppController())->getAuthUser($request);

        if($user->hasRole('management') || $user->hasRole('administrator')){
            $vehicles= Vehicle::orderBy('vehicleRegistrationNumber','asc')->get();
        }else
            $vehicles= Vehicle::orderBy('vehicleRegistrationNumber','asc')->where('verified',1)->get();

        if ((new AppController())->isApi($request))
            //API Response
            return response()->json(VehicleResource::collection($vehicles));
        else{
            //Web Response
            return Inertia::render('Vehicles/Index',[
                'vehicles'     =>  VehicleResource::collection($vehicles),
            ]);
        }

    }
    public function create(Request $request)
    {
        return Inertia::render('Vehicles/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            "vehicleRegistrationNumber" =>  ['required','unique:vehicles'],
            "mileage"                   =>  ['required','numeric'],
        ]);

        if(isset($request->lastRefillFuelReceived))
            $request->validate(["lastRefillFuelReceived" =>  'numeric']);

        if(isset($request->lastRefillMileageCovered))
            $request->validate(["lastRefillMileageCovered" =>  'numeric']);

        $vehicle=Vehicle::create([
            "photo"                         =>  $request->photo,
            "vehicleRegistrationNumber"     =>  strtoupper($request->vehicleRegistrationNumber),
            "mileage"                       =>  $request->mileage,
            "lastRefillDate"                =>  $request->lastRefillDate,
            "lastRefillFuelReceived"        =>  $request->lastRefillFuelReceived,
            "lastRefillMileageCovered"      =>  $request->lastRefillMileageCovered,
            "verified"                      =>  false,
        ]);

        //Run notifications
        (new NotificationController())->notifyManagement($vehicle,"VEHICLE_NEW");

        if ((new AppController())->isApi($request)) {
            //API Response
            return response()->json(new VehicleResource($vehicle),201);
        }else{
            //Web Response
            return Redirect::route('vehicles')->with('success','Vehicle created');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(Request $request,$id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle)) {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(new VehicleResource($vehicle));
            }else{
                //Web Response
                return Inertia::render('Vehicles/Show',[
                    'vehicle' => new VehicleResource($vehicle)
                ]);
            }

        }
        else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'Vehicle not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','Vehicle not found');
            }
        }
    }

    public function edit(Request $request,$id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle)) {

            if($vehicle->verified) {
                return Redirect::back()->with('error','Vehicle is not editable');
            }

            return Inertia::render('Vehicles/Edit',[
                'vehicle' => new VehicleResource($vehicle)
            ]);
        }
        else {
            return Redirect::back()->with('error','Vehicle not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle)){

            if($vehicle->verified) {
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message' => 'Vehicle is not editable'], 404);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','Vehicle is not editable');
                }
            }

            $request->validate([
                "vehicleRegistrationNumber" =>  ['required'],
                "mileage"                   =>  ['required'],
            ]);

            if(isset($request->lastRefillFuelReceived))
                $request->validate(["lastRefillFuelReceived" =>  'numeric']);

            if(isset($request->lastRefillMileageCovered))
                $request->validate(["lastRefillMileageCovered" =>  'numeric']);

            if (isset($request->photo)){
                if ($request->photo != $vehicle->photo){
                    if (file_exists($vehicle->photo))
                        Storage::disk("public_uploads")->delete($vehicle->photo);
                }
            }

            $vehicle->update([
                "photo"                         =>  $request->photo,
                "vehicleRegistrationNumber"     =>  strtoupper($request->vehicleRegistrationNumber),
                "mileage"                       =>  $request->mileage,
                "lastRefillDate"                =>  $request->lastRefillDate,
                "lastRefillFuelReceived"        =>  $request->lastRefillFuelReceived,
                "lastRefillMileageCovered"      =>  $request->lastRefillMileageCovered,
            ]);

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(new VehicleResource($vehicle));
            }else{
                //Web Response
                return Redirect::route('vehicles')->with('success','Vehicle updated');
            }

        }
        else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'Vehicle not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','Vehicle not found');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function verify(Request $request, $id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle)){

            $vehicle->update([
                "verified"  =>  true,
            ]);

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(new VehicleResource($vehicle));
            }else{
                //Web Response
                return Redirect::route('vehicles')->with('success','Vehicle verified');
            }
        }
        else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'Vehicle not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','Vehicle not found');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Request $request,$id)
    {
        $vehicle=Vehicle::find($id);

        if (is_object($vehicle)){

            if($vehicle->verified) {
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message' => 'Vehicle cannot be deleted'], 404);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','Vehicle cannot be deleted');
                }

            }

            //delete avatar
            if(file_exists($vehicle->photo)){
                Storage::disk("public_uploads")->delete($vehicle->photo);
            }

            $vehicle->delete();

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message'=>'Vehicle has been deleted']);
            }else{
                //Web Response
                return Redirect::route('vehicles')->with('success','Vehicle has been deleted');
            }


        } else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'Vehicle not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','Vehicle not found');
            }
        }
    }
}
