<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class PricesController extends Controller implements DashboardInterface
{
    public function index(): Factory|View|Application
    {
        return view('dashboard.prices', [
            'prices' => Price::all()
        ]);
    }

    public function detailedPage(Request $request): Factory|View|Application
    {
        return view('dashboard.pricedetail', [
            'price' => Price::where('id', $request->id)->first()
        ]);
    }

    public function create(Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);
        $price = new Price();

        $price->name = $request->name;
        $price->price = $request->price;

        $price->save();
        notify()->success('Tarief aangemaakt!');
        return redirect()->back();
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);
        $price = Price::where('id', $request->id)->first();

        $price->name = $request->name;
        $price->price = $request->price;

        $price->update();
        notify()->success('Tarief geupdated!');
        return redirect()->back();
    }

    public function delete(Request $request): RedirectResponse
    {
        $price = Price::where('id', $request->id);
        $price->delete();
        notify()->success('Tarief verwijderd.');
        return redirect()->back();
    }
}
