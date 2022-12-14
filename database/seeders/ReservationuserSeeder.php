<?php

namespace Database\Seeders;

use App\Models\Reservationuser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reservationuser::factory()->count(10)->create();
    }
}
