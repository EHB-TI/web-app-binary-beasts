<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\User;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::factory(10)->create();
        $users = User::whereBetween("id", [2, 20])->get();
        error_log($users->count());
        $event = Event::find(1);
        foreach($users as $user){
            error_log($user->name);
            $event->attendees()->attach($user);
        }
        
    }
}