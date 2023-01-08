<?php

namespace App\Http\Controllers;

use GdImage;
use Illuminate\Support\Str;

class ImageUploadController
{
    public function uploadImg($data): ?string
    {
        $file = $data->image;
        if ($file == null) {
            return null;
        }
        $image = $file->move(public_path('images'), $file->getClientOriginalName());
        return "images/".basename($image);
    }
}
