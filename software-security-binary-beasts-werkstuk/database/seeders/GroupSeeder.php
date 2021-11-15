<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
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
        $testGroup = new Group([
            "name" => "Test group",
            "date" => Carbon::now(),
            'admin_id' => 3,
        ]);
        $testGroup->save();
    }
}
