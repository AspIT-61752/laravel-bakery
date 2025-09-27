<?php

namespace App\Services;

use App\DataHandler\ImageUploadResult;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function uploadProductImage($image, $productName)
    {
        // https://laravel.com/docs/12.x/filesystem#storing-files

        // Image prep
        $storePath = ('products/' . Str::slug($productName, '-') . "/" . "images");

        $fileUrl = $this->uploadImage($storePath, $image);

        return $fileUrl;
    }

    public function uploadProfileImage($image)
    {

        // Image prep
        $storePath = ('users/' . Auth::id() . "/" . "images/");

        $fileUrl = $this->uploadImage($storePath, $image);

        return $fileUrl;
    }

    private function uploadImage($path, $image)
    {
        try {

            // Final image prep
            $date = (new DateTime())->format('Y-m-d_H-i-s');
            $ext = $image->extension();
            $filename = ($date . " - " . fake()->uuid() . '.' . $ext);

            // Store the image
            Storage::disk('public')->putFileAs($path, $image, $filename);

            // After storing, get the URL
            $fileUrl = Storage::url($path . '/' . $filename);

            // Return the file URL
            return $fileUrl;
        } catch (\Throwable $th) {
            dd($th);
            throw $th;
        }
    }
}
