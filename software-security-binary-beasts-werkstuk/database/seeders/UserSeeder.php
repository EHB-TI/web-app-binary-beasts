<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User([
            "name" => "admin",
            "password" => bcrypt("Admin1"),
            "email" => "admin@ehb.be"
        ]);
        $admin->save();

        $student = new User([
            "name" => "student",
            "password" => bcrypt("Student1"),
            "email" => "student@student.ehb.be"
        ]);
        $student->save();

        $teacher = new User([
            "name" => "teacher",
            "password" => bcrypt("Teacher1"),
            "email" => "teacher@teacher.ehb.be"
        ]);
        $teacher->save();
    }
}
