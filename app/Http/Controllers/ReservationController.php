<?php

namespace App\Http\Controllers;

use App\Http\Traits\TimeTrait;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use TimeTrait;

    public function index(): Factory|View|Application
    {
        return view('reservation', ['reservations' => Reservation::with('user')->get(),
            'myReservation' => Reservation::where(function ($query) {
                $query->where('user_1_id', Auth::id())
                    ->orWhere('user_2_id', Auth::id())
                    ->orWhere('user_3_id', Auth::id())
                    ->orWhere('user_4_id', Auth::id());
            })->with('user', 'participant1', 'participant2', 'participant3')
                ->first(),
            'users' => User::where('role_id', 2)->get(),
            'times' => $this->timeSlots()
        ]);
    }

    public function create(Request $request): RedirectResponse
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
        notify()->success('Reservering aangemaakt!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $reservation = Reservation::where('id', $request->reservation);
        $reservation->delete();
        notify()->success('Reservering verwijderd.');
        return redirect()->back();
    }

    public function checkAvailability(Request $request)
    {
        if ($request->reservation['participant1'] &&
            $request->reservation['participant2'] &&
            $request->reservation['track'] &&
            $request->reservation['date']) {
            $reservations = Reservation::where(function ($query) use ($request) {
                $query->where('user_1_id', $request->reservation['participant1'])
                    ->orWhere('user_2_id', $request->reservation['participant1'])
                    ->orWhere('user_3_id', $request->reservation['participant1'])
                    ->orWhere('user_4_id', $request->reservation['participant1'])
                    ->orWhere('user_1_id', $request->reservation['participant2'])
                    ->orWhere('user_2_id', $request->reservation['participant2'])
                    ->orWhere('user_3_id', $request->reservation['participant2'])
                    ->orWhere('user_4_id', $request->reservation['participant2'])
                    ->orWhere('user_1_id', $request->reservation['participant3'])
                    ->orWhere('user_2_id', $request->reservation['participant3'])
                    ->orWhere('user_3_id', $request->reservation['participant3'])
                    ->orWhere('user_4_id', $request->reservation['participant3'])
                    ->orWhere('user_1_id', $request->reservation['participant4'])
                    ->orWhere('user_2_id', $request->reservation['participant4'])
                    ->orWhere('user_3_id', $request->reservation['participant4'])
                    ->orWhere('user_4_id', $request->reservation['participant4']);
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
