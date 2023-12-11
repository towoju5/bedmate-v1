<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        try {
            $reviews = Review::whereUserId($userId)->get();
            return get_success_response($reviews);
        } catch (\Throwable $th) {
            get_error_response(["error" => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        try {
            $validate = $request->validate([
                'content'   =>  'required',
                'ratings'   =>  'required|numeric|min:1,max:5',
            ]);

            $validate['user_id'] = $userId;
            $validate['rated_by'] = auth()->id();
            if($review = Review::create($validate)){
                return get_success_response($review, 201);
            }
        } catch (\Exception $e) {
            // Return an error response
            return get_error_response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $review = Review::findOrFail($id);
            return get_success_response($review);
        } catch (\Exception $e) {
            // Return an error response
            return get_error_response(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = $request->validate([
                'content'   =>  'required',
                'ratings'   =>  'required|numeric|min:1,max:5',
            ]);

            $review = Review::findOrFail($id);
            $review->update($validate);
            return response()->json(['msg' => 'Review updated successfully', 'review' => $review], 200);
        } catch (\Exception $e) {
            // Return an error response
            return get_error_response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $review = Review::findOrFail($id);
            if($review->delete())  {
                return get_success_response (['msg' => 'Review deleted successfully'], 200);
            }
        } catch (\Exception $e) {
            return get_error_response(['error' => $e->getMessage()], 500);
        }
    }
}
