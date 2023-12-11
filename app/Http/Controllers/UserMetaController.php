<?php

namespace App\Http\Controllers;

use App\Models\UserMeta;
use Illuminate\Http\Request;

class UserMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = getUserByMetaData(auth()->id());
            if($user != false) {
                return get_success_response($user);
            }

            return get_error_response(['error' => "User with the provided data does not exists"]);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'meta_data' => 'required'
            ]);

            foreach ($request->meta_data as $value) {
                $save[] = UserMeta::create([
                    'user_id' => auth()->id(),
                    'key'   =>  $value[0],
                    'value' =>  $value[1]
                ]);
            }
            return get_error_response(['error' => "Error encountered please contact support"]);
            if($save) {
                return get_success_response($save);
            }
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     * search by key or value
     */
    public function show(Request $request)
    {
        try {
            $r = $request;
            $user = getUserByMetaData(auth()->id(), $r->key ?? null, $r->value ?? null);
            if($user != false) {
                return get_success_response($user);
            }

            return get_error_response(['error' => "User with the provided data does not exists"]);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $key)
    {
        try {
            $where  = [
                'user_id' => auth()->id(),
                'key'     => $key
            ];
            $meta = UserMeta::where($where)->first();
            $meta->key  = $request->key;
            $meta->value = $request->value;
            if($meta->save())  {
                return get_success_response($meta);
            }
            return get_error_response(['error' => "Unable to update record"]);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $key)
    {
        try {
            $where  = [
                'user_id' => auth()->id(),
                'key'     => $key
            ];
            $meta = UserMeta::where($where)->first();
            if($meta->delete())  {
                return get_success_response($meta);
            }
            return get_error_response(['error' => "Unable to delete record"]);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }
}
