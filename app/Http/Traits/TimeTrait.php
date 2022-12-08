<?php

namespace App\Http\Traits;

trait TimeTrait {

    /**
     * @return string[]
     * Return alle tijdslots in een array
     */
    public function timeSlots(): array
    {
        return [
            '09:00',
            '10:00',
            '11:00',
            '12:00',
            '13:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00',
            '18:00',
            '19:00',
            '20:00',
            '21:00',
            '22:00',
            '23:00'
        ];
    }
}
