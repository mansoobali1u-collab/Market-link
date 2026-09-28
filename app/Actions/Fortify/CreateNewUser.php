<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Notifications\FarmerRegisteredNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
   public function create(array $input): User
{
    Validator::make($input, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => $this->passwordRules(),
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        'role' => ['required', 'string', 'in:user,farmer'],
    ])->validate();


    $user = User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'role' => $input['role'],
    ]);

    if ($user->role === 'farmer') {
        User::where('role', 'admin')->get()->each(function ($admin) use ($user) {
            $admin->notify(new FarmerRegisteredNotification($user));
        });
    }

    return $user;
}}