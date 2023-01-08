<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    public function index()
    {
        $file_path = 'storage/downloads/Inschrijfformulier_TClievelde.doc';

        if (file_exists(public_path($file_path))) {
            $file = asset($file_path);
        } else {
            $file = asset('storage/downloads/Inschrijfformulier_TClievelde.pdf');
        }

        return view('prices', [
            'prices' => Price::all(),
            'file' => $file
        ]);
    }
}
