<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

class HomeController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('welcome', ['posts' => Post::latest()->paginate(3)]);
    }
}
