<?php

namespace App\Actions\Fortify;

use App\Http\Controllers\NotificationController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            "firstName"     => ['required','string', 'max:255'],
            "lastName"      => ['required','string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'device_name'   => ['required','string'],
            'positionId'    => ['required','integer'],
        ])->validate();

        $user= User::create([
            "firstName"     => ucwords($input['firstName']),
            "middleName"    => ucwords($input['middleName']),
            "lastName"      => ucwords($input['lastName']),
            'position_id'   => $input['positionId'],
            'email'         => $input['email'],
            'password'      => Hash::make($input['password']),
        ]);

        $role=Role::where('name','unverified')->first();
        $user->roles()->attach($role);

        //Run notifications
        (new NotificationController())->notifyManagement($user,"USER_NEW");

        return $user;
    }
}
