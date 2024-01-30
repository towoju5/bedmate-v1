<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $bookings = Booking::whereUserId(auth()->id())->get();
            return get_success_response($bookings);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function getAllBookingsWithEscortDetails()
    {
        try {
            $bookings = Booking::all();
            foreach ($bookings as $booking) {
                $escortIds = $booking->escort_ids;
                $escortDetails = User::whereIn('id', $escortIds)->get();
                $booking->participants = $escortDetails;
            }
            return get_success_response($bookings);
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
            $booking = new Booking();
            $booking->user_id = auth()->id();
            $booking->service_date = $request->service_date; // day escort(s) service is needed.
            $booking->service_time = $request->service_time; // time of the day escort(s) service is needed.
            $booking->meta_data = $request->meta_data ?? null;
            $booking->escort_count = $request->total_escorts;
            $booking->escort_ids = $request->escort_ids; // => accept arrays or json ID os escorts.
            $booking->booking_cost = $request->booking_cost;
            $booking->kinks = $request->kinks;
            $booking->is_escort_accept = false; // 1 -> accept, 2 -> reject, 0 -> pending, 3 -> cancelled
            $booking->service_location = $request->service_location;
            return get_success_response($booking);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $bookingId)
    {
        try {
            $booking = Booking::findOrFail($bookingId);
            $escortIds = $booking->escort_ids;
            $escortDetails = User::whereIn('id', $escortIds)->get();
            if ($escortDetails->count() !== count($escortIds)) {
                return response()->json(['error' => 'Not all escort details could be retrieved.'], 400);
            }
            $booking->participants = $escortDetails;
            get_success_response($booking);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
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
        //
    }
}
