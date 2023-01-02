<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\Activate;
use App\Mail\Deactivate;
use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller implements DashboardInterface
{
    public function index(): Factory|View|Application
    {
        return view('dashboard.users', [
            'users' => User::orderBy('membership_id', 'ASC')
                ->get()
        ]);
    }

    public function detailedPage(Request $request): Factory|View|Application
    {
        return view('dashboard.userdetail', [
            'user' => User::where('id', $request->id)->first()
        ]);
    }

    public function create(Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|unique:users',
            'membership_id' => 'required|unique:users'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->membership_id = $request->membership_id;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);
        $user->active = 1;
        $user->save();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ];

        Mail::to($request->email)
            ->send(new Welcome($data));

        notify()->success('Gebruiker aangemaakt.');
        return redirect()->back();
    }

    public function update(Request $request): RedirectResponse
    {
        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->membership_id = $request->membership_id;
        $user->role_id = $request->role_id;
        $request->validate([
            'email' => 'required|unique:users,email,'.$user->id,
            'membership_id' => 'unique:users,membership_id,'.$user->id
        ]);
        $user->save();
        notify()->success('Gebruiker aangepast.');
        return redirect()->back();
    }

    public function delete(Request $request): RedirectResponse
    {
        $user = User::where('id', $request->id)->first();
        $user->active = 0;
        $user->save();

        $data = [
            'name' => $user->name,
            'email' => $user->email
        ];
        Mail::to($user->email)
            ->send(new Deactivate($data));

        notify()->success('Gebruiker is niet meer actief.');
        return redirect()->back();
    }

    public function activate(Request $request): RedirectResponse
    {
        $user = User::where('id', $request->id)->first();
        $user->active = 1;
        $user->save();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ];
        Mail::to($user->email)
            ->send(new Activate($data));

        notify()->success('Gebruiker is weer actief.');
        return redirect()->back();
    }
}
