<?php

namespace App\Http\Controllers;

use App\Http\Traits\TimeTrait;
use App\Mail\Removed;
use App\Mail\ReservationMail;
use App\Mail\Update;
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
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    use TimeTrait;

    public function index(): Factory|View|Application
    {
        Reservation::where('date', '<', now()->toDateString())->delete();
        Reservation::where('time', '<', now()->toTimeString())
            ->where('date', now()->toDateString())
            ->delete();
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
            'participant1' => 'required|distinct',
            'participant2' => 'required|distinct',
            'participant3' => 'distinct',
            'participant4' => 'distinct',
            'date' => 'required|after:yesterday',
            'time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $date = $request->date;
                    if ($date == Carbon::now()->format('Y-m-d') && $value < Carbon::now()->format('H:i')) {
                        $fail('De tijd moet na de huidige tijd liggen als de datum vandaag is.');
                    }
                },
            ],
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

        foreach($reservation->users()->get() as $user) {
            $data = [
                'date' => $reservation->date,
                'time' => $reservation->time,
                'track' => $reservation->track,
                'name' => $user->name
            ];

            Mail::to($user->email)
                ->send(new ReservationMail($data));
        }
        notify()->success('Reservering aangemaakt!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $reservation = Reservation::find($request->reservation);
        $reservation->delete();

        foreach($reservation->users()->get() as $user) {
            $data = [
                'date' => $reservation->date,
                'time' => $reservation->time,
                'track' => $reservation->track,
                'name' => $user->name
            ];

            Mail::to($user->email)
                ->send(new Removed($data));
        }

        $reservation->users()->detach();
        notify()->success('Reservering verwijderd.');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'participant1' => 'required|distinct',
            'participant2' => 'required|distinct',
            'participant3' => 'distinct',
            'participant4' => 'distinct',
            'date' => 'required|after:yesterday',
            'time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $date = $request->date;
                    if ($date == Carbon::now()->format('Y-m-d') && $value < Carbon::now()->format('H:i')) {
                        $fail('De tijd moet na de huidige tijd liggen als de datum vandaag is.');
                    }
                },
            ],
            'track' => 'required'
        ]);
        $reservation = Reservation::where('id', $request->id)->first();
        $reservation->date = Carbon::parse($request->date)->format('Y-m-d');
        $reservation->time = $request->time;
        $reservation->track = $request->track;

        $reservation->update();

        $users = User::whereIn('id', [
            $request->participant1,
            $request->participant2,
            $request->participant3,
            $request->participant4
        ])
            ->get();

        $reservation->users()->sync($users);

        foreach($reservation->users()->get() as $user) {
            $data = [
                'date' => $reservation->date,
                'time' => $reservation->time,
                'track' => $reservation->track,
                'name' => $user->name
            ];

            Mail::to($user->email)
                ->send(new Update($data));
        }
        notify()->success('Reservering geupdated!');
        return redirect()->back();
    }

    public function checkAvailability(Request $request): ?JsonResponse
    {
        if ($request->reservation['track'] && $request->reservation['date']) {
            $reservations = Reservation::where('track', $request->reservation['track'])
                ->where('date', $request->reservation['date'])
                ->orderBy('time', 'asc')
                ->get();

            $thisReservation = null;
            if ($request->reservation['id']) {
                $thisReservation = Reservation::where('id', $request->reservation['id'])
                    ->first();
            }

            $times = $this->getTimes($reservations);
            if ($thisReservation) {
                $times[] = $thisReservation->time;
                sort($times);
            }
            return empty($times) ?
                response()->json('Met deze combinatie zijn er geen tijden beschikbaar.', 404) :
                response()->json($times);
        }
        return null;
    }

    public function getTimes($reservations): array
    {
        $allTimes = $this->timeSlots();

        foreach ($reservations as $reservation) {
            if ($reservation->endtime) {
                foreach ($this->removeRoundHours($allTimes, $reservation->time, $reservation->endtime) as $key => $hour) {
                    unset($allTimes[$key]);
                }
            }
            if (($k = array_search($reservation->time, $allTimes)) !== false) {
                unset($allTimes[$k]);
            }
        }

        return $allTimes;
    }

    public function removeRoundHours($hours, $starthour, $endhour): array
    {
        return array_filter($hours, function ($hour) use ($starthour, $endhour) {
            return $hour >= $starthour && $hour < $endhour;
        });
    }
}
