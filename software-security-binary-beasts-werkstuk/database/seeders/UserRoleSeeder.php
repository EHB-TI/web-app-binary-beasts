<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Get the roles
        $adminRole = Role::find(1);
        $studentRole = Role::find(2);
        $teacherRole = Role::find(3);

        // Get the users
        $adminUser = User::find(1);
        $studentUser = User::find(2);
        $teacherUser = User::find(3);

        // Link both together
        $adminUser->roles()->attach($adminRole);
        $studentUser->roles()->attach($studentRole);
        $teacherUser->roles()->attach($teacherRole);
        
    }
}
