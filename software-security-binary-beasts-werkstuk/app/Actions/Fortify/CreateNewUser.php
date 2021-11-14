<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CreateNewUser implements CreatesNewUsers
{
    const STUDENT = 'STUDENT';
    const ADMIN = 'ADMIN';
    const TEACHER = 'TEACHER';
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        // Separate string by @ characters (there should be only one)
        $parts = explode('@', $input['email']);
        $domain = array_pop($parts);
        $domain_parts=explode('.',$domain);

        $role=null;

        if(strtolower($domain_parts[0])==strtolower(self::STUDENT))
            $role=DB::table('roles')->where('role_name', self::STUDENT)->first();
        elseif (strtolower($domain_parts[0])== strtolower(self::TEACHER))
            $role=DB::table('roles')->where('role_name', self::TEACHER)->first();;


        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        if($role!=null)
            $user->role()->attach($role->id);
        return $user;


    }
}
