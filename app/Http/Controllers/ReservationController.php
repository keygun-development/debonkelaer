<?php

namespace App\Http\Controllers;

use App\Http\Traits\TimeTrait;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use TimeTrait;

    public function index()
    {
        return view('reservation', [
            'reservations' => Reservation::with('user')->get(),
            'myReservation' => Reservation::where(function ($query) {
                $query->where('creator', Auth::id())
                    ->orWhere('participant_1_id', Auth::id())
                    ->orWhere('participant_2_id', Auth::id())
                    ->orWhere('participant_3_id', Auth::id());
            })->with('user', 'participant1', 'participant2', 'participant3')
                ->first(),
            'users' => User::all(),
            'times' => $this->timeSlots()
        ]);
    }

    public function create(Request $request)
    {
        dd($request->participant1);
    }
}
