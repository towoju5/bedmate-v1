<?php

namespace App\Http\Controllers;

use App\Models\Stories;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $stories = Stories::whereDate('created_at', '>=', now()->subHours(24))->inRandomOrder()->limit(20)->get();
            return get_success_response($stories);
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
                'story_type' => 'required'
            ]);
          
          	if($request->story_type == 'image'){
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,png,gif,mp4,mv4,mov,avi,heic,heif,jpg'
                ]);
            }
          
          	if($request->story_type == 'text'){
                $request->validate([
                    'content' => 'required'
                ]);
            }
          
            $stories = new Stories();
          	$stories->user_id = auth()->id();
            $stories->type = $request->story_type;
            $stories->content = $request->content ??  null;
            if($request->has('image')) : 
                $stories->images = save_image($request->image, 'stories');
            endif;
            $stories->save();

            return get_success_response($stories);
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
            $story =  Stories::whereId($id)->first();
            if($story)
                return get_success_response($story);
            return get_error_response(['error' =>  "Record doesn't exist or has been deleted"]);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $gallery =  Stories::whereUserId(auth()->id())->first();
            if($gallery->delete())
                return get_success_response(['message' => 'Record deleted successfully']);
            return get_error_response(['error' =>  'Unable to delete, please contact support']);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }
}
