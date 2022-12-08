<?php

namespace App\Http\Controllers;

use App\Models\Impression;
use Illuminate\Http\Request;

class ImpressionController extends Controller
{
    public function index()
    {
        return view('impressions');
    }

    public function getImpressions()
    {
        return response()->json(Impression::all());
    }
}
