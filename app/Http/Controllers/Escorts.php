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
                ->when($request->has('age'), function ($query) use ($request) {
                    $age = explode('-', $request->age);
                    $query->whereBetween('amount', [$age[0], $age[1]]);
                })
                ->when($request->has('location'), function ($query) use ($request) {
                    // Assuming the request has 'latitude' and 'longitude' keys
                    $user = $request->user();
                    $latitude = $user->latitude;
                    $longitude = $user->longitude;
                    $radius = $request->location; 

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
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function becomeAkinks()
    {
        try {
            $escort = new User();
            if ($escort->ActivateKink()) {
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
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            if ((int) auth()->id() !== (int) $id) {
                return get_error_response(['error' => 'You can only delete your own account']);
            }
            $record = User::whereId($id)->first();
            if ($record->delete()) {
                return get_success_response(['message' => 'Record deleted successfully']);
            }

            return get_error_response(['error' => 'Unable to delete, please contact support']);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Packages API for kinks
     */

    public function getPackages($escortId)
    {
        try {
            $escort = User::findOrFail($escortId);
            if($escort->is_escort == false) {
                return get_error_response(['error' => "This endpoint is only available for kinks"]);
            }
            $package = $escort->packages()->get();
            return get_success_response($package, 201);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function addPackage(Request $request, $escortId)
    {
        try {
            $request->validate([
                'package_name' => 'required',
                'package_price' => 'required|numeric',
                'package_duration' => 'required|string',
                'package_type' => 'sometimes',
                'other_package_details' => 'sometimes',
            ]);

            $escort = User::findOrFail($escortId);
            $package = $escort->packages()->create($request->all());

            return get_success_response($package, 201);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function updatePackage(Request $request, $escortId, $packageId)
    {
        try {
            $request->validate([
                'package_name' => 'required',
                'package_price' => 'required|numeric',
                'package_duration' => 'required|string',
                'package_type' => 'sometimes',
                'other_package_details' => 'sometimes',
            ]);

            $escort = User::findOrFail($escortId);
            $package = $escort->packages()->findOrFail($packageId);
            $package->update($request->all());

            return get_success_response($package, 200);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function deletePackage($escortId, $packageId)
    {
        try {

            $escort = User::findOrFail($escortId);
            $package = $escort->packages()->findOrFail($packageId);
            $package->delete();

            return get_success_response(null, 204);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }
}
