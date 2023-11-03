<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $gallery =  Gallery::whereUserId(auth()->id())->get();
            return get_success_response($gallery);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'media_type' => 'required|in:image,video',
                'media_file' => 'required|file|mimes:jpeg,png,gif,mp4,mv4,mov,avi,heic,heif,jpg'
            ]);
            $userId = auth()->id();
            $gallery =  new Gallery;
            $gallery->mdeia_type = $request->media_type;
            $gallery->user_id = $userId;
            if($request->media_type == 'image'):
                $gallery->media_url = save_image($request->file('media_file'), "gallery/".sha1($userId));
            else :
                $gallery->media_url = save_media($request->file('media_file'), "gallery/".sha1($userId));
            endif;
            $gallery->save();
            return get_success_response($gallery);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $gallery =  Gallery::whereUserId(auth()->id())->whereId($id)->first();
            return get_success_response($gallery);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $gallery =  Gallery::whereUserId(auth()->id())->whereId($id)->first();
            if($gallery->delete())
                return get_success_response(['message' => 'Record deleted successfully']);
            return get_error_response(['error' =>  'Unable to delete, please contact support']);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }
}
