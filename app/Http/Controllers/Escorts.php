<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Escorts extends Controller
{
    public function kinks(Request $request)
    {
        try {
            $kinks = User::whenHas('tags', function ($query) use ($request) {
                $query->whereJsonContains('tags', $request->tags);
            })->whenHas('fees', function ($query) use ($request) {
                $fee = explode('-', $request->fees);
                $query->whereBetween('amount', [$fee[0], $fee[1]]);
            })->whenHas('location', function($query) use ($request) {
                $query->where('location', $request->location);
            })->where('is_escort', true)->inRandomOrder()->get();
        
            return get_success_response($kinks);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }

    public function kink(Request $request, $id)
    {
        try {
            $kink = User::where('id', $id)->with('messages',  'orders')->findorfail();
            return get_success_response($kink);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $record =  User::whereUserId(auth()->id())->whereId($id)->findorfail();
            if($record->delete())
                return get_success_response(['message' => 'Record deleted successfully']);
            return get_error_response(['error' =>  'Unable to delete, please contact support']);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }
}
