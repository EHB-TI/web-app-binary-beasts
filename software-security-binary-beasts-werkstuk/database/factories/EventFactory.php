<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'eventname' => $this->faker->company(),
            'eventdescription' => $this->faker->catchPhrase(),
            'eventdate' => $this->faker->date(),
            'eventtime' => $this->faker->time(),
            'host_id' => 3,     
        ];       
    }
}