<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
class ImageHelper
{
    public static function save_image(UploadedFile $image, $uploadPath = 'uploads')
    {
<<<<<<< HEAD
        // Validate the image
        $image->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048', // Adjust max size as needed
        ]);
=======
        $image->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048', // Adjust max size as needed
        ]);

        // Generate a unique file name
        $fileName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

        // Store the image in the specified path
        $imagePath = $image->storeAs($uploadPath, $fileName, 'public');

        // Generate and return the image URL
        $imageUrl = asset('storage/' . $imagePath);

        return $imageUrl;
        // $image->validate([
        //     'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048', // Adjust max size as needed
        // ]);
>>>>>>> 8125e3ebae0a0c64387a90095e9faf4a8e98bd79

        // Generate a unique file name
        $fileName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

        // Store the image in the specified path
        $imagePath = $image->storeAs($uploadPath, $fileName, 'public');

        // Generate and return the image URL
        $imageUrl = asset('storage/' . $imagePath);

        return $imageUrl;

//         $compressedImage = cloudinary()->upload($image->getRealPath(), [
//             'folder' => 'uploads',
//             'transformation' => [
//                 'quality' => 'auto',
//                 'fetch_format' => 'auto'
//             ]
//         ])->getSecurePath();
        
//         dd($compressedImage);
    }
}
