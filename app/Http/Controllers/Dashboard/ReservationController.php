<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Traits\TimeTrait;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

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
            'users' => User::whereDoesntHave('reservation')->get(),
            'times' => $this->timeSlots()
        ]);
    }

    public function delete(Request $request): RedirectResponse
    {
        $reservation = Reservation::find($request->id);
        $reservation->delete();

        $reservation->users()->detach();
        notify()->success('Reservering verwijderd.');
        return redirect()->back();
    }

    public function create(Request $request): Redirector|Application|RedirectResponse
    {
        $reservation = new Reservation();

        $reservation->track = $request->track;
        $reservation->date = $request->date;
        $reservation->time = $request->timestart;
        $reservation->endtime = $request->timeend;

        $reservation->save();
        notify()->success('Baan afgeschermd.');
        return redirect()->back();
    }

    public function update(Request $request): RedirectResponse
    {
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
        notify()->success('Reservering geupdated!');
        return redirect()->back();
    }
}
