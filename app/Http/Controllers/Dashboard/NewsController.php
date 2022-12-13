<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use GdImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        return view('dashboard.news', [
            'posts' => Post::with('author')->get()
        ]);
    }

    public function newPost()
    {
        return view('dashboard.newpost');
    }

    public function slugPage(Request $request)
    {
        return view('dashboard.newsdetail', [
            'post' => Post::where('post_slug', $request->post_slug)
                ->with('author')
                ->first(),
        ]);
    }

    public function create(Request $request) {
        $post = new Post();

        if ($request->image) {
            $post->post_image = $this->uploadImg($request);
        }
        $post->post_title = $request->title;
        $post->post_slug = Str::slug($request->title);
        $post->author_id = Auth::id();
        $post->post_content = $request->postcontent;

        $post->save();
        notify()->success('Post aangemaakt!');
        return redirect('/dashboard/nieuws');
    }

    public function update(Request $request)
    {
        $post = Post::where('id', $request->id)->first();
        if ($request->image) {
            $post->post_image = $this->uploadImg($request);
        }
        $post->post_title = $request->title;
        $post->post_content = $request->postcontent;

        $post->update();
        notify()->success('Post geupdated!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $post = Post::where('id', $request->id);
        $post->delete();
        notify()->success('Post verwijderd.');
        return redirect()->back();
    }

    private function uploadImg($data): ?string
    {
        $file = $data->image;
        if ($file == null) {
            return null;
        }
        $file_ext = $file->getClientOriginalExtension();
        $destinationPath = "images/";
        $uuid = Str::uuid()->toString();
        $file_location = "$destinationPath$uuid.webp";
        $this->convertImageToWebp($file, $file_ext, $file_location);
        return $file_location;
    }

    private function convertImageToWebp($file, $file_extension, $file_location): void
    {
        $temp_img = null;
        switch ($file_extension) {
            case "jpg":
            case "jpeg":
                $temp_img = imagecreatefromjpeg($file);
                break;
            case "png":
                $temp_img = $this->pngToWebp($file);
                break;
            case "webp":
                $temp_img = imagecreatefromwebp($file);
                break;
        }
        imagewebp($temp_img, $file_location, 100);
    }

    private function pngToWebp($file): GdImage|bool
    {
        $pngimg = imagecreatefrompng($file);

        $w = imagesx($pngimg);
        $h = imagesy($pngimg);

        $image = imagecreatetruecolor($w, $h);
        imageAlphaBlending($image, false);
        imageSaveAlpha($image, true);
        $trans = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefilledrectangle($image, 0, 0, $w - 1, $h - 1, $trans);
        imagecopy($image, $pngimg, 0, 0, 0, 0, $w, $h);
        return $image;
    }
}
