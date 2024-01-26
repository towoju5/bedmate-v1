<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Escorts extends Controller
{
    public function kinks(Request $request)
    {
        try {
            $query = User::where('is_escort', true)
                ->inRandomOrder()
                ->when($request->has('tags'), function ($query) use ($request) {
                    $query->whereJsonContains('tags', $request->tags);
                })
                ->when($request->has('plan'), function ($query) use ($request) {
                    // Add logic for plan if needed
                })
                ->when($request->has('fees'), function ($query) use ($request) {
                    $fee = explode('-', $request->fees);
                    $query->whereBetween('amount', [$fee[0], $fee[1]]);
                })
                ->when($request->has('location'), function ($query) use ($request) {
                    // Assuming the request has 'latitude' and 'longitude' keys
                    $user = $request->user();
                    $latitude = $user->latitude;
                    $longitude = $user->longitude;
                    $radius = $request->location; // The radius in kilometers

                    $query->selectRaw(
                        '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                        [$latitude, $longitude, $latitude]
                    )
                        ->having('distance', '<', $radius)
                        ->orderBy('distance');
                })
                ->paginate(24);

            return get_success_response($query);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }

    public function becomeAkinks()
    {
        try {
            $escort = new User();
            if($escort->ActivateKink()){
                return get_success_response(['msg' => "User successfully upgraded to escort"]);
            }
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function kink(Request $request, $id)
    {
        try {
            $kink = User::with('messages', 'orders')->find($id);
            return get_success_response($kink);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            if ((int)auth()->id() !== (int)$id) {
                return get_error_response(['error' =>  'You can only delete your own account']);
            }
            $record =  User::whereId($id)->first();
            if ($record->delete())
                return get_success_response(['message' => 'Record deleted successfully']);
            return get_error_response(['error' =>  'Unable to delete, please contact support']);
        } catch (\Throwable $th) {
            return get_error_response(['error' =>  $th->getMessage()]);
        }
    }


    public function addPackage(Request $request, $escortId)
    {
        $request->validate([
            'package_name' => 'required',
            'package_price' => 'required|numeric',
            'package_duration_days' => 'required|integer',
            'package_type' => 'sometimes',
            'other_package_details' => 'sometimes'      
        ]);

        $escort = Escorts::findOrFail($escortId);
        $package = $escort->packages()->create($request->all());

        return response()->json($package, 201);
    }

    public function updatePackage(Request $request, $escortId, $packageId)
    {
        $request->validate([
            'package_name' => 'required',
            'package_price' => 'required|numeric',
            'package_duration_days' => 'required|integer',
            'package_type' => 'sometimes',
            'other_package_details' => 'sometimes' 
        ]);

        $escort = Escorts::findOrFail($escortId);
        $package = $escort->packages()->findOrFail($packageId);
        $package->update($request->all());

        return response()->json($package, 200);
    }

    public function deletePackage($escortId, $packageId)
    {
        $escort = Escorts::findOrFail($escortId);
        $package = $escort->packages()->findOrFail($packageId);
        $package->delete();

        return response()->json(null, 204);
    }
}
