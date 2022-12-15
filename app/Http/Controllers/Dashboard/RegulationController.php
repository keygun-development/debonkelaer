<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Regulation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class RegulationController extends Controller implements DashboardInterface
{
    public function index(): Factory|View|Application
    {
        return view('dashboard.regulations', [
            'regulations' => Regulation::all()
        ]);
    }

    public function create(Request $request): Redirector|Application|RedirectResponse
    {
        $regulation = new Regulation();

        $regulation->name = $request->name;
        $regulation->description = $request->postcontent;

        $regulation->save();
        notify()->success('Regel opgeslagen.');
        return redirect()->back();
    }

    public function delete(Request $request): RedirectResponse
    {
        $regulation = Regulation::where('id', $request->id);
        $regulation->delete();
        notify()->success('Regel verwijderd.');
        return redirect()->back();
    }

    public function detailedPage(Request $request): Factory|View|Application
    {
        return view('dashboard.regulationdetail', [
            'regulation' => Regulation::where('id', $request->id)->first()
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $regulation = Regulation::where('id', $request->id)->first();
        $regulation->name = $request->name;
        $regulation->description = $request->postcontent;
        $regulation->update();
        notify()->success('Regel aangepast.');
        return redirect()->back();
    }
}
