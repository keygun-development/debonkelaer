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
        $file_ext = $file->getClientOriginalExtension();
        $destinationPath = "images/";
        $uuid = Str::uuid()->toString();
        $file_location = "$destinationPath$uuid.webp";
        $this->convertImageToWebp($file, $file_ext, $file_location);
        return $file_location;
    }

    public function convertImageToWebp($file, $file_extension, $file_location): void
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

    public function pngToWebp($file): GdImage|bool
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
