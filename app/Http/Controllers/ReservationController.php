<?php

namespace App\Http\Controllers;

use App\Http\Traits\TimeTrait;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use TimeTrait;

    public function index()
    {
        return view('reservation', ['reservations' => Reservation::with('user')->get(),
            'myReservation' => Reservation::where(function ($query) {
                $query->where('user_1_id', Auth::id())
                    ->orWhere('user_2_id', Auth::id())
                    ->orWhere('user_3_id', Auth::id())
                    ->orWhere('user_4_id', Auth::id());
            })->with('user', 'participant1', 'participant2', 'participant3')
                ->first(),
            'users' => User::all(),
            'times' => $this->timeSlots()
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'participant1' => 'required',
            'participant2' => 'required',
            'date' => 'required|after:yesterday',
            'time' => 'required',
            'track' => 'required'
        ]);

        $reservation = new Reservation();

        $reservation->user_1_id = $request->participant1;
        $reservation->user_2_id = $request->participant2;
        $reservation->user_3_id = $request->participant3;
        $reservation->user_4_id = $request->participant4;
        $reservation->date = Carbon::parse($request->date)->format('Y-m-d');
        $reservation->time = $request->time;
        $reservation->track = $request->track;

        $reservation->save();
        return redirect()->back()->with('message', 'Reservering aangemaakt.');
    }

    public function checkAvailability(Request $request)
    {
        if ($request->reservation['participant1'] &&
            $request->reservation['participant2'] &&
            $request->reservation['participant3'] &&
            $request->reservation['participant4'] &&
            $request->reservation['track'] &&
            $request->reservation['date']) {
            $reservations = Reservation::where(function ($query) use ($request) {
                for ($i = 1; $i <= 4; $i++) {
                    for ($x = 1; $x <= 4; $x++) {
                        $query->where('user_' . $x . '_id', $request->reservation['participant' . $i])
                            ->orWhere('user_' . $x . '_id', $request->reservation['participant' . $i])
                            ->orWhere('user_' . $x . '_id', $request->reservation['participant' . $i])
                            ->orWhere('user_' . $x . '_id', $request->reservation['participant' . $i]);
                    }
                }
            })
                ->where('track', $request->reservation['track'])
                ->where('date', $request->reservation['date'])
                ->orderBy('time', 'asc')
                ->get();

            return empty($this->getTimes($reservations)) ?
                response()->json('Met deze combinatie zijn er geen tijden beschikbaar.', 404) :
                response()->json($this->getTimes($reservations));
        }
        return null;
    }

    public function getTimes($reservations): array
    {
        $allTimes = $this->timeSlots();

        foreach ($reservations as $reservation) {
            if (($k = array_search($reservation->time, $allTimes)) !== false) {
                unset($allTimes[$k]);
            }
        }

        return $allTimes;
    }
}
