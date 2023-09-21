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
            $stories = Stories::whereDate('created_at', '>=', now()->subHours(24))->get();
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
            $stories = new Stories();
            $stories->type = $request->story_type;
            $stories->content = $request->content;
            if($request->has('image')) : 
                $stories->image = $request->image;
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
            $story =  Stories::whereUserId(auth()->id())->whereId($id)->findorfail();
            if($story)
                return get_success_response(['message' => 'Record deleted successfully']);
            return get_error_response(['error' =>  'Unable to delete, please contact support']);
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
            $gallery =  Stories::whereUserId(auth()->id())->whereId($id)->findorfail();
            if($gallery->delete())
                return get_success_response(['message' => 'Record deleted successfully']);
            return get_error_response(['error' =>  'Unable to delete, please contact support']);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }
}
