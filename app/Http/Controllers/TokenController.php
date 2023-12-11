<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationMail;
use App\Models\ResetToken;
use App\Notifications\PasswordResetNotification;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|exists:users,email'
            ]);

            $user = User::where('email', $request->email)->first();
            $token = strtoupper(Str::random(8));

            ResetToken::create([
                'email' => $request->email,
                'token' => $token
            ]);

            $user->notify(new OtpVerificationMail($token));

            return get_success_response(['msg' => 'Please check your email for your reset token']);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function verifyToken(string $token)
    {
        try {
            // check if token exists
            $tokenExists = ResetToken::where(['email' => auth()->user()->email, 'token' => $token])->first();
            if ($tokenExists) {
                return get_success_response(['succes', "Token verified successfully"]);
            }
            return get_error_response(['error', "Invalid Email or token provided"], 404);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
