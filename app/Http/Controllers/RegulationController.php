<?php

namespace App\Http\Controllers;

use App\Models\Regulation;
use Illuminate\Http\Request;

class RegulationController extends Controller
{
    public function index()
    {
        return view('regulations', ['regulations' => Regulation::all()]);
    }
}
