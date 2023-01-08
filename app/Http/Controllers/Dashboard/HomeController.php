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
        $files = glob(public_path('downloads/*'));

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $file = $request->file('form');
        $file->move(public_path('downloads'), $file->getClientOriginalName());

        return redirect()->back()->with('success', 'Nieuwe inschrijfformulier is succesvol toegevoegd!');
    }
}
