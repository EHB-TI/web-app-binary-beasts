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
            "password" => bcrypt("Admin2"),
            "email" => "admin@ehb.be",
            "email_verified_at" => Now()
        ]);
        $admin->save();

        $student = new User([
            "name" => "StudentName",
            "password" => bcrypt("Student2"),
            "email" => "student@student.ehb.be",
            "email_verified_at" => Now()
        ]);
        $student->save();

        $teacher = new User([
            "name" => "TeacherName",
            "password" => bcrypt("Teacher2"),
            "email" => "teacher@teacher.ehb.be",
            "email_verified_at" => Now()
        ]);
        $teacher->save();

        // Use the factory class to create a bunch or random profiles
        User::factory(75)->create();
    }
}