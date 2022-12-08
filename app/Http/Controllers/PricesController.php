<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    public function index()
    {
        return view('prices', ['prices' => Price::all()]);
    }
}
