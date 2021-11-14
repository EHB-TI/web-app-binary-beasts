<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Role::create([
                'role_name'=>'ADMIN',
                'role_description'=>'full rights'
            ]);
        Role::create([
            'role_name'=>'STUDENT',
            'role_description'=>'Student Account'
        ]);
        Role::create([
            'role_name'=>'TEACHER',
            'role_description'=>'Teacher Account'
        ]);
    }
}
