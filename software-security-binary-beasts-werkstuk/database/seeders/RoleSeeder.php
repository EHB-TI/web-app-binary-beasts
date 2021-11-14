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
                'role_name'=>'Admin',
                'role_description'=>'full rights'
            ]);
        Role::create([
            'role_name'=>'Student',
            'role_description'=>'Student Account'
        ]);
        Role::create([
            'role_name'=>'Teacher',
            'role_description'=>'Teacher Account'
        ]);
    }
}
