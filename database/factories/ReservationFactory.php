<?php

namespace Database\Factories;

use App\Http\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    use TimeTrait;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $times = $this->timeSlots();
        return [
            'creator' => fake()->numberBetween(1, 10),
            'participant_1_id' => fake()->numberBetween(1, 10),
            'participant_2_id' => fake()->numberBetween(1, 10),
            'participant_3_id' => fake()->numberBetween(1, 10),
            'date' => fake()->dateTimeBetween('-30 days', '+30 days'),
            'time' => $times[array_rand($times)],
            'track' => fake()->numberBetween(1, 2)
        ];
    }
}
