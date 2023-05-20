<?php

namespace App\Http\Controllers;

use App\Http\Resources\PositionResource;
use App\Http\Resources\RequestFormResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Jobs\SendMail;
use App\Mail\UserNewMail;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

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
            "firstName"     => ['required','string', 'max:255'],
            "lastName"      => ['required','string', 'max:255'],
            "email"         => ['required','unique:users','email','string'],
            "password"      => ['required', 'confirmed', new \Laravel\Fortify\Rules\Password, 'string'],
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

        //Add to report
        $report=(new ReportController())->getCurrentReport();
        $report->users()->attach($report);

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

                //If position is finance or human resource make accountant
                if ($user->position->id == 3 || $user->position->id == 5){
                    //Give this user an accountant role
                    $accountantRole=Role::where('name','accountant')->first();
                    $user->roles()->attach($accountantRole);
                }

                //If position is a manager
                if($user->position->id == 1 /*|| $user->position->id == 7*/){
                    $user->roles()->detach();
                    $managementRole=Role::where('name','management')->first();
                    $user->roles()->attach($managementRole);
                }

                //Run notifications
                (new NotificationController())->notifyUser($user,"USER_VERIFIED");


                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(new UserResource($user));
                }else{
                    //Web Response
                    return Redirect::back()->with('success','User has been verified');
                }

            }else {
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message' => 'User already verified'], 405);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','User already verified');
                }
            }

        }else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'User not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','User not found');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function discard(Request $request, $id)
    {
        $user=User::find($id);

        if (is_object($user)){
            //delete unverified users
            foreach ($user->roles as $role)
                $user->roles()->detach($role);

            $user->delete();

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'User Discarded']);
            }else{
                //Web Response
                return Redirect::back()->with('success','User Discarded');
            }

        }else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'User not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','User not found');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function giveRole(Request $request, $id, $role)
    {
        $user=User::find($id);

        if (is_object($user)){

            $roleObject=Role::where('name',$role)->first();
            $user->roles()->attach($roleObject);

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => "User can act as a $role"]);
            }else{
                //Web Response
                return Redirect::back()->with('success',"User can act as a $role");
            }

        }else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'User not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','User not found');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function revokeRole(Request $request, $id, $role)
    {
        $user=User::find($id);

        if (is_object($user)){

            //reject if user is a superuser
            if ($id == 1){
                if ((new AppController())->isApi($request)) {
                    //API Response
                    return response()->json(['message' => 'Cannot revoke this user']);
                }else{
                    //Web Response
                    return Redirect::back()->with('error','Cannot revoke this user');
                }
            }

            $roleObject=Role::where('name',$role)->first();
            $user->roles()->detach($roleObject);

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => "User can no longer act as a $role"]);
            }else{
                //Web Response
                return Redirect::back()->with('success',"User can no longer act as a $role");
            }

        }else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'User not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','User not found');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function disable(Request $request, $id)
    {
        $user=User::find($id);

        if (is_object($user)){

            if ($user->hasRole('management')){

                $managementRole=Role::where('name','management')->first();
                $managers=$managementRole->users;

                if ($managers->count()==1){
                    if ((new AppController())->isApi($request)) {
                        //API Response
                        return response()->json(['message'=>'Cannot disabled this user. There is no other user holding a management position.'],405);
                    }else{
                        //Web Response
                        return Redirect::back()->with('error','Cannot disabled this user. There is no other user holding a management position.');
                    }
                }
            }

            //remove all roles
            foreach ($user->roles as $role)
                $user->roles()->detach($role);

            //Give this user an unverified role
            $disabledRole=Role::where('name','disabled')->first();
            $user->roles()->attach($disabledRole);

            //Run notifications
            (new NotificationController())->notifyUser($user,"USER_DISABLED");

            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(new UserResource($user));
            }else{
                //Web Response
                return Redirect::back()->with('success','User disabled');
            }

        }else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'User not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','User not found');
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $users=User::orderBy('firstName','asc')->paginate((new AppController())->paginate);

        //Web
        $positions=Position::orderBy('title','asc')->get();
        $roles=Role::orderBy('name','asc')->get();

        if ((new AppController())->isApi($request)) {
            //API Response
            return response()->json(UserResource::collection($users));
        }else{
            //Web Response
            return Inertia::render('Users/Index',[
                'users'         =>  UserResource::collection($users),
                'positions'     =>  PositionResource::collection($positions),
                'roles'         =>  RoleResource::collection($roles)
            ]);
        }


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
     */
    public function show(Request $request,$id)
    {
        $user=User::find($id);

        if (is_object($user)) {
            $totalRequests=$user->requestForms->count();

            //For Pie Chart
            $cashRequestsCount=$user->requestForms()->where('type','CASH')->count();
            $materialsRequestsCount=$user->requestForms()->where('type','MATERIALS')->count();
            $vehicleMaintenanceRequestsCount=$user->requestForms()->where('type','VEHICLE_MAINTENANCE')->count();
            $fuelRequestsCount=$user->requestForms()->where('type','FUEL')->count();

            //Page Info
            $approvedRequestsCount=$user->requestForms()->where('approvalStatus','>',0)->where('approvalStatus','<',4)->where('approvalStatus','!=',2)->count();
            $pendingRequestsCount=$user->requestForms()->where('approvalStatus',0)->count();
            $deniedRequestsCount=$user->requestForms()->where('approvalStatus',2)->count();
            $closedRequestsCount=$user->requestForms()->where('approvalStatus','>',3)->count();

            //Requests section
            $activeRequests=$user->requestForms()->where('approvalStatus','<',4)->orderBy('dateRequested','desc')->get();
            $closedRequests=$user->requestForms()->where('approvalStatus','>',3)->orderBy('dateRequested','desc')->paginate((new AppController())->paginate);

            $response=[
                'user'                              =>  new UserResource($user),
                'totalRequests'                     => $totalRequests,
                'cashRequestsCount'                 => $cashRequestsCount,
                'materialsRequestsCount'            => $materialsRequestsCount,
                'vehicleMaintenanceRequestsCount'   => $vehicleMaintenanceRequestsCount,
                'fuelRequestsCount'                 => $fuelRequestsCount,
                'approvedRequestsCount'             => $approvedRequestsCount,
                'pendingRequestsCount'              => $pendingRequestsCount,
                'deniedRequestsCount'               => $deniedRequestsCount,
                'closedRequestsCount'               => $closedRequestsCount,
                'activeRequests'                    => RequestFormResource::collection($activeRequests),
                'closedRequests'                    => RequestFormResource::collection($closedRequests),
            ];

            if ((new AppController())->isApi($request))
                //API Response
                return response()->json($response);
            else{
                //Web Response
                return Inertia::render('Users/Show',$response);
            }
        }
        else {
            if ((new AppController())->isApi($request)) {
                //API Response
                return response()->json(['message' => 'User not found'], 404);
            }else{
                //Web Response
                return Redirect::back()->with('error','User not found');
            }

        }
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
