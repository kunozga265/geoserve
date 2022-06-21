<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $positions= Position::orderBy('title','asc')->get();
        return view('auth.register')->with('positions',$positions);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            "firstName"     => ['required','string', 'max:255'],
            "lastName"      => ['required','string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'device_name'   => ['required','string'],
            'positionId'    => ['required','integer'],
        ]);

        $user = User::create([
            "firstName"     => ucwords($request->firstName),
            "middleName"    => ucwords($request->middleName),
            "lastName"      => ucwords($request->lastName),
            'position_id'   => $request->positionId,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
        ]);

        $role=Role::where('name','unverified')->first();
        $user->roles()->attach($role);

        //Run notifications
        (new NotificationController())->notifyManagement($user,"USER_NEW");

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
