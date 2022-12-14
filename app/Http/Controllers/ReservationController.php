<?php

namespace App\Http\Controllers;

use App\Http\Traits\TimeTrait;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use TimeTrait;

    public function index(): Factory|View|Application
    {
        return view('reservation', [
            'reservations' => Reservation::has('users')->with('users')->get(),
            'myReservation' => User::where('id', Auth::id())
                ->has('reservation')
                ->with('reservation')
                ->first(),
            'users' => User::whereDoesntHave('reservation')->get(),
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
        $reservation->date = Carbon::parse($request->date)->format('Y-m-d');
        $reservation->time = $request->time;
        $reservation->track = $request->track;

        $reservation->save();

        $users = User::whereIn('id', [
            $request->participant1,
            $request->participant2,
            $request->participant3,
            $request->participant4
        ])
            ->get();

        $reservation->users()->attach($users);
        notify()->success('Reservering aangemaakt!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $reservation = Reservation::find($request->reservation);
        $reservation->delete();
        $reservation->users()->detach();
        notify()->success('Reservering verwijderd.');
        return redirect()->back();
    }

    public function checkAvailability(Request $request): ?JsonResponse
    {
        if ($request->reservation['track'] && $request->reservation['date']) {
            $reservations = Reservation::where('track', $request->reservation['track'])
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
