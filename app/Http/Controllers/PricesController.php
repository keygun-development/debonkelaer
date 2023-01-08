<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    public function index()
    {
        $files = glob(public_path('downloads/*'));

        if (file_exists($files[0])) {
            $file = asset('downloads/'.basename($files[0]));
        }

        return view('prices', [
            'prices' => Price::all(),
            'file' => $file
        ]);
    }
}
