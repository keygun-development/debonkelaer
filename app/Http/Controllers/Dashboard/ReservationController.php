<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Traits\TimeTrait;
use App\Mail\Overwrite;
use App\Mail\Removed;
use App\Mail\ReservationMail;
use App\Mail\Update;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller implements DashboardInterface
{
    use TimeTrait;

    public function index(): Factory|View|Application
    {
        return view('dashboard.reservation', [
            'reservations' => Reservation::with('users')
                ->orderBy('date', 'asc')
                ->get(),
            'times' => $this->timeSlots()
        ]);
    }

    public function detailedPage(Request $request): Factory|View|Application
    {
        return view('dashboard.reservationdetail', [
            'reservation' => Reservation::where('id', $request->id)
                ->with('users')
                ->first(),
            'users' => User::whereDoesntHave('reservation')
                ->where('active', 1)
                ->get(),
            'times' => $this->timeSlots()
        ]);
    }

    public function delete(Request $request): RedirectResponse
    {
        $reservation = Reservation::find($request->id);
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

    public function create(Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate([
            'track' => 'required',
            'date' => 'required|after:yesterday',
            'timestart' => 'required',
            'timeend' => 'required|after:timestart'
        ]);
        $reservationsBetween = Reservation::where('track', $request->track)
            ->where('date', $request->date)
            ->whereBetween('time', [
                $request->timestart, $request->timeend
            ])
            ->get();

        $reservation = new Reservation();

        $reservation->track = $request->track;
        $reservation->date = $request->date;
        $reservation->time = $request->timestart;
        $reservation->endtime = $request->timeend;

        $reservation->save();
        foreach($reservationsBetween as $reservationBetween) {
            foreach($reservationBetween->users()->get() as $user) {
                $data = [
                    'date' => $reservation->date,
                    'time' => $reservation->time,
                    'track' => $reservation->track,
                    'name' => $user->name
                ];

                Mail::to($user->email)
                    ->send(new Overwrite($data));
            }
        }
        notify()->success('Baan afgeschermd.');
        return redirect()->back();
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'track' => 'required',
            'date' => 'required|after:yesterday',
            'time' => 'required',
            'participant1' => 'required|distinct',
            'participant2' => 'required|distinct',
            'participant3' => 'distinct',
            'participant4' => 'distinct',
        ]);
        $reservation = Reservation::where('id', $request->id)->first();
        $reservation->date = Carbon::parse($request->date)->format('Y-m-d');
        $reservation->time = $request->time;
        $reservation->endtime = $request->timeend ?? null;
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
}
