<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements DashboardInterface
{
    public function index(): Factory|View|Application
    {
        return view('dashboard.users', [
            'users' => User::all()
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
        notify()->success('Gebruiker is niet meer actief.');
        return redirect()->back();
    }

    public function activate(Request $request): RedirectResponse
    {
        $user = User::where('id', $request->id)->first();
        $user->active = 1;
        $user->save();
        notify()->success('Gebruiker is weer actief.');
        return redirect()->back();
    }
}
