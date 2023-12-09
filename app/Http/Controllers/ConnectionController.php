<?php

namespace App\Http\Controllers;

use App\Events\ConnectionRequestEvent;
use App\Http\Requests\ConnectionRequestValidationRequest;
use App\Models\Connection;
use App\Notifications\ConnectionRequestNotification;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function createConnection(ConnectionRequestValidationRequest $request)
    {
        try {
            $request->validate([
                'booking_id' =>  'required',
            ]);
            $user = auth()->user();

            $connection = Connection::create([
                'user_id' => $user->id,
                'connection_id' => $request->booking_id,
                'status' => 'pending',
            ]);

            return get_success_response($connection);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function acceptConnection(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $connection = Connection::findOrFail($id);

            // Check if the authenticated user is the recipient of the connection request
            if ($user->id === $connection->connection_id) {
                $connection->update(['status' => 'accepted']);

                // Trigger event or notification for accepted connection
                event(new ConnectionRequestEvent($connection));
                $connection->connectionUser->notify(new ConnectionRequestNotification($connection, 'accepted'));

                return get_success_response(['message' => 'Connection request accepted successfully', 'connection' => $connection]);
            }

            return get_error_response(['message' => 'Unauthorized'], 403);
        } catch (\Exception $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function rejectConnection(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $connection = Connection::findOrFail($id);

            // Check if the authenticated user is the recipient of the connection request
            if ($user->id === $connection->connection_id) {
                $connection->update(['status' => 'rejected']);

                // Trigger event or notification for rejected connection
                event(new ConnectionRequestEvent($connection));
                $connection->connectionUser->notify(new ConnectionRequestNotification($connection, 'rejected'));

                return get_success_response(['message' => 'Connection request rejected successfully']);
            }

            return get_error_response(['message' => 'Unauthorized'], 403);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function payForConnection(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $connection = Connection::findOrFail($id);

            // Check if the authenticated user is a male and the connection is pending
            if ($user->gender === 'male' && $connection->status === 'pending') {
                // Your logic for payment goes here
                $connection->update(['payment_status' => 'paid']);

                // Trigger event or notification for paid connection
                event(new ConnectionRequestEvent($connection));
                $connection->connectionUser->notify(new ConnectionRequestNotification($connection, 'paid'));

                return get_success_response(['message' => 'Connection request payment successful', 'connection' => $connection]);
            }

            return get_error_response(['message' => 'Unauthorized or invalid request'], 403);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }



    public function getConnectionGroupCount()
    {
        $user = auth()->user();

        $connectionCount = $user->connections()->count();

        return response()->json(['message' => 'Connection group count retrieved successfully', 'count' => $connectionCount]);
    }
}
