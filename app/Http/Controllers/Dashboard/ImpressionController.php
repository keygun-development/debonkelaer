<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageUploadController;
use App\Models\Impression;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ImpressionController extends Controller implements DashboardInterface
{
    public function index(): Factory|View|Application
    {
        return view('dashboard.impressions', [
            'impressions' => Impression::all()
        ]);
    }

    public function detailedPage(Request $request): Factory|View|Application
    {
        // TODO: Implement detailedPage() method.
    }

    public function create(Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate([
            'image' => 'required',
        ]);
        $impression = new Impression();
        $impression->image = (new ImageUploadController)->uploadImg($request);
        $impression->save();
        notify()->success('Impressie toegevoegd!');
        return redirect()->back();
    }

    public function update(Request $request): RedirectResponse
    {
        // TODO: Implement update() method.
    }

    public function delete(Request $request): RedirectResponse
    {
        $impression = Impression::find($request->id);
        $impression->delete();
        notify()->success('Impressie verwijderd!');
        return redirect()->back();
    }
}
