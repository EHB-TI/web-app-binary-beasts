<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\User;
use App\Models\Event;

class GroupEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = User::find(3);
        $groups = Group::factory(3)->has(Event::factory()->count(5))->create();
        foreach($groups as $group){
            error_log($group->name);
            $group->members()->attach($teacher);
        }
    }
}