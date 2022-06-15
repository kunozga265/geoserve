<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Jobs\SendMail;
use App\Mail\UserNewMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            "email"         => ['required'],
            "password"      => ['required'],
            'device_name'   => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token=$user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'user'  =>  new UserResource($user),
            'token' =>  $token
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $request->validate([
            "firstName"     => ['required'],
            "lastName"      => ['required'],
            "email"         => ['required','unique:users'],
            "password"      => ['required', 'confirmed', Password::min(8)],
            'device_name'   => ['required'],
            'positionId'    => ['required'],
        ]);

        $user=User::create([
            "firstName"     => ucwords($request->firstName),
            "middleName"    => ucwords($request->middleName),
            "lastName"      => ucwords($request->lastName),
            "email"         => $request->email,
            "password"      => bcrypt($request->password),
            'position_id'   => $request->positionId,
        ]);

        $role=Role::where('name','unverified')->first();
        $user->roles()->attach($role);

        $token=$user->createToken($request->device_name)->plainTextToken;

        //Run notifications
        (new NotificationController())->notifyManagement($user,"USER_NEW");

        return response()->json([
            'user'  =>  new UserResource($user),
            'token' =>  $token
        ]);
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

        $user=User::find($id);

        if (is_object($user)){

            if ($user->hasRole('unverified')){
                //Remove unverified role
                $unverifiedRole=Role::where('name','unverified')->first();
                $user->roles()->detach($unverifiedRole);

                //Give this user an employee (verified) role
                $employeeRole=Role::where('name','employee')->first();
                $user->roles()->attach($employeeRole);

                //If position is administrative secretary
                if ($user->position->id == 2){
                    //Give this user an administrative role
                    $administratorRole=Role::where('name','administrator')->first();
                    $user->roles()->attach($administratorRole);
                }

                //If position is an accountant
                if ($user->position->id == 3){
                    //Give this user an accountant role
                    $accountantRole=Role::where('name','accountant')->first();
                    $user->roles()->attach($accountantRole);
                }

                //Run notifications
                (new NotificationController())->notifyUser($user,"USER_VERIFIED");

                return response()->json(new UserResource($user));

            }else
                return response()->json(['message'=>'User already verified'],405);

        }else
            return response()->json(['message'=>'User not found'],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function disable(Request $request, $id)
    {
        $user=User::find($id);

        if (is_object($user)){

            if ($user->hasRole('management') || $user->hasRole('administrator')){
                return response()->json(['message'=>'Cannot disabled this user'],405);
            }elseif ($user->hasRole('employee')){
                //Remove employee role
                $employeeRole=Role::where('name','employee')->first();
                $user->roles()->detach($employeeRole);

                //Give this user an unverified role
                $unverifiedRole=Role::where('name','unverified')->first();
                $user->roles()->attach($unverifiedRole);

                //Run notifications
                (new NotificationController())->notifyUser($user,"USER_DISABLED");

                return response()->json(new UserResource($user));

            }else
                return response()->json(['message'=>'User already disabled'],405);

        }else
            return response()->json(['message'=>'User not found'],404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users=User::all();
        return response()->json(UserResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user=User::find($id);

        if (is_object($user))
            return response()->json(new UserResource($user));
        else
            return response()->json(['message'=>'User not found'],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
