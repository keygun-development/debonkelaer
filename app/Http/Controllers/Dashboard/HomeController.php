<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'form' => 'required'
        ]);
        $files = glob(storage_path('app/public/downloads/*'));

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $file = $request->file('form');
        $file->storeAs('public/downloads', 'Inschrijfformulier_TClievelde.'.$file->getClientOriginalExtension());

        return redirect()->back()->with('success', 'Nieuwe inschrijfformulier is succesvol toegevoegd!');
    }
}
