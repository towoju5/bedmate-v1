<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $compressedImage = cloudinary()->upload($request->file('image')->getRealPath(), [
            'folder' => 'uploads',
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ],
        ])->getSecurePath();
        dd($compressedImage);
    }

}
