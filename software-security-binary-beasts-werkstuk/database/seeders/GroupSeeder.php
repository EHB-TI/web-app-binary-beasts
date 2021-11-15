<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creates a testgroup where our seeded Teacher is the admin and the seeded Student is a member
        $testGroup = new Group([
            "name" => "Test group",
            "date" => Carbon::now(),
            'admin_id' => 3,
        ]);
        $testGroup->save();

        
        $student = User::find(2);
        $testGroup->members()->attach($student);
    }
}
