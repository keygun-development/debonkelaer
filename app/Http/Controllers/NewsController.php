<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('news', ['posts' => Post::latest()->paginate(10)]);
    }

    public function slugPage(Request $request)
    {
        return view('newsdetail', [
            'post' => Post::where('post_slug', $request->post_slug)
                ->with('author')
                ->first(),
        ]);
    }
}
