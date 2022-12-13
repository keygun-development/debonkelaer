<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    public function index()
    {
        return view('dashboard.prices', [
            'prices' => Price::all()
        ]);
    }

    public function idPage(Request $request)
    {
        return view('dashboard.pricedetail', [
            'price' => Price::where('id', $request->id)->first()
        ]);
    }

    public function create(Request $request)
    {
        $price = new Price();

        $price->name = $request->name;
        $price->price = $request->price;

        $price->save();
        notify()->success('Tarief aangemaakt!');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $price = Price::where('id', $request->id)->first();

        $price->name = $request->name;
        $price->price = $request->price;

        $price->update();
        notify()->success('Tarief geupdated!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $price = Price::where('id', $request->id);
        $price->delete();
        notify()->success('Tarief verwijderd.');
        return redirect()->back();
    }
}
