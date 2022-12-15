<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageUploadController;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller implements DashboardInterface
{
    public function index(): Factory|View|Application
    {
        return view('dashboard.news', [
            'posts' => Post::with('author')->get()
        ]);
    }

    public function newPost(): Factory|View|Application
    {
        return view('dashboard.newpost');
    }

    public function detailedPage(Request $request): Factory|View|Application
    {
        return view('dashboard.newsdetail', [
            'post' => Post::where('post_slug', $request->post_slug)
                ->with('author')
                ->first(),
        ]);
    }

    public function create(Request $request): Redirector|Application|RedirectResponse
    {
        $post = new Post();

        if ($request->image) {
            $post->post_image = (new ImageUploadController)->uploadImg($request);
        }
        $post->post_title = $request->title;
        $post->post_slug = Str::slug($request->title);
        $post->author_id = Auth::id();
        $post->post_content = $request->postcontent;

        $post->save();
        notify()->success('Post aangemaakt!');
        return redirect('/dashboard/nieuws');
    }

    public function update(Request $request): RedirectResponse
    {
        $post = Post::where('id', $request->id)->first();
        if ($request->image) {
            $post->post_image = (new ImageUploadController)->uploadImg($request);
        }
        $post->post_title = $request->title;
        $post->post_content = $request->postcontent;

        $post->update();
        notify()->success('Post geupdated!');
        return redirect()->back();
    }

    public function delete(Request $request): RedirectResponse
    {
        $post = Post::where('id', $request->id);
        $post->delete();
        notify()->success('Post verwijderd.');
        return redirect()->back();
    }
}
