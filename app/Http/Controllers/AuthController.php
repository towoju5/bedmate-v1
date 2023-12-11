<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationMail;
use App\Models\ResetToken;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Registration;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'email'     =>  'required|email',
                'password'  =>  'required',
                'latitude'  =>  'required',
                'longitude' =>  'required',
            ]
        );

        if ($validateUser->fails()) {
            return get_error_response($validateUser->errors(), 401);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return get_error_response([
                'message' => 'Email & Password does not match with our record.',
            ], 401);
        }
        try {

            $user = User::where('email', $request->email)->first();
            if (null == $user->email_verified_at) {
                return get_error_response(["message" => "Please verify your email to continue"], 401);
            }
            $auth_token = $user->api_token;
            if (empty($auth_token)) {
                Auth::user()->tokens->each(function ($token, $key) {
                    $token->delete();
                });
                $auth_token = Auth::user()->createToken('api-token');
                $user->api_token = explode("|", $auth_token->plainTextToken);

                // update user location
                $user->latitude = $request->latitude;
                $user->longitude = $request->longitude;

                // log user location history to user history file => get user location-history.txt and append location
                $data = json_encode([
                    now() => [
                        "latitude" => $request->latitude,
                        "longitude" => $request->longitude,
                    ]
                ]);
                File::append(storage_path("$user->username/location-history.txt"), $data);

                // update user ::DB record
                $user->save();
            }
            return get_success_response(['token' => $user->api_token]);
        } catch (\Throwable $th) {
            return get_error_response($th->getMessage(), 500);
        }
    }

    public function register(Request $request)
    {
        //Validated
        $validateUser = Validator::make(
            $request->all(),
            [
                'email'         =>  'required|email|unique:users,email',
                'password'      =>  'required',
                'name'          =>  'required',
                'username'      =>  'required|unique:users,username'
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }
        try {

            $user = User::create([
                "name"     =>  $request->name,
                "email"    =>  $request->email,
                "username" =>  $request->username,
                "password" =>  Hash::make($request->password)
            ]);
            $apiToken = $user->createToken("API_TOKEN")->plainTextToken;
            $user->api_token = $apiToken;
            $user->save();
            $this->sendMail($user->toArray());

            // fire event for successful registration and send mail

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'data'    => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        if ($request->has('phone') && (NULL !== $request->phone)) {
            $_userData['phone']  = $request->phone;
        }

        if ($request->has('password') && (NULL !== $request->password)) {
            $_userData['password'] = bcrypt($request->password);
        }

        if ($request->has("name") && !empty($request->name)) {
            $_userData['name'] = $request->name;
        }

        if ($request->has("gender") && !empty($request->gender)) {
            $_userData['gender'] = $request->gender;
        }

        if ($request->has("sexual_preference") && !empty($request->sexual_preference)) {
            $_userData['sexual_preference'] = $request->sexual_preference;
        }

        if ($request->has("interested_in") && !empty($request->interested_in)) {
            $_userData['interested_in'] = $request->interested_in;
        }

        if ($request->has("kinks") && !empty($request->kinks)) {
            $_userData['kinks'] = $request->kinks;
        }

        if ($request->has("bio") && !empty($request->bio)) {
            $_userData['bio'] = $request->bio;
        }

        if ($request->has("is_escort") && !empty($request->is_escort)) {
            $_userData['is_escort'] = $request->is_escort;
        }

        if ($request->has("impression") && !empty($request->impression)) {
            $_userData['impression'] = $request->impression;
        }

        if ($request->has("location") && !empty($request->location)) {
            $_userData['location'] = $request->location;
        }

        if ($request->has("tags") && !empty($request->tags)) {
            $_userData['tags'] = $request->tags;
        }

        if ($request->has("api_token") && !empty($request->api_token)) {
            $_userData['api_token'] = $request->api_token;
        }

        if ($request->has("plans") && !empty($request->plans)) {
            $_userData['plans'] = $request->plans;
        }

        if ($request->has("metadata") && !empty($request->metadata)) {
            $_userData['metadata'] = $request->metadata;
        }


        if (empty($_userData)) {
            return get_error_response(["error" => "No data was passed"]);
        }

        $query = ['id' => auth()->id()];
        if ($user = User::where($query)->update($_userData)) {
            return get_success_response([
                'data'   => getUsers()
            ]);
        } else {
            return get_error_response($user);
        }
    }

    /**
     * Receive user email address and generate reset token
     */
    public function resend_verification_email(Request $request)
    {
        try {
            $user = User::where(['email' => $request->email, 'email_verified_at' => null])->first();
            if (!$user) {
                return get_error_response(['msg' => 'Invalid data supplied or Email already verified.'], 400);
            }
            return $this->sendMail($user->toArray());
        } catch (\Throwable $th) {
            get_error_response(["error" => $th->getMessage()]);
        }
    }

    /**
     * Verify if reset token is valid and reset user password
     */
    public function verify_email(Request $request)
    {
        $this->validate($request, [
            'code'  =>  'required|min:6|max:6',
            'email' =>  'required'
        ]);

        $data = DB::table('reg_codes')->where(['code' => $request->code])->first();

        if ($data) {
            if ($request->email == $data->email) {
                DB::table('users')->where(['email' => $data->email])->update([
                    'email_verified_at' => Carbon::now()
                ]);
                //Toastr::success('Password reset successfully.');
                DB::table('reg_codes')->where('email', $request->email)->delete();
                return get_success_response(['message' => 'Email verified successfully.'], 200);
            }
            return get_error_response(['errors' => [
                ['code' => 'mismatch', 'message' => 'Invalid token supplied.']
            ]], 401);
        }
        return get_error_response(['msg' => 'Invalid token supplied.'], 400);
    }


    public function transaction_pin(Request $request, $action = NULL)
    {
        $user = User::find(auth()->id());

        if ($request->has('pin') && strlen($request->pin) != 4) {
            return response()->json(get_error_response("Error PIN can not be longer than 4 digits"))->original;
        }
        if ($action == 'verify') {
            $incomingPin = (int)$request->pin;
            $oldPin = $user->transaction_pin;
            if (Hash::check($incomingPin, $oldPin)) {
                return response()->json([
                    'status' => true,
                    'code'   => http_response_code(),
                    'message' => "Transaction verified successfully",
                    'data'   => ["msg" => "Pin verified successfully"]
                ]);
            } else {
                return get_error_response("Error, Invalid Pin Provided!");
            }
        }
        if ($action == 'update') {
            $incomingPin = (int)$request->pin;
            $user->is_pin_set = 1;
            $user->transaction_pin = bcrypt($incomingPin);
            if ($user->save()) {
                return get_success_response(["msg" => "Pin Updated successfully"]);
            } else {
                $err = "We're currenctly unable to update your transaction pin please try again later";
                return response()->json(get_error_response($err));
            }
        }
        return response()->json(get_error_response("Unknown action requested. Check your request endpoint please."));
    }

    public static function sendMail(array $customer)
    {
        if (is_array($customer)) {
            $token = rand(100001, 999999);
            $user = User::find($customer['id']);
            DB::table('reg_codes')->insert([
                'email' => $customer['email'],
                'code'  => $token,
                'created_at' => now(),
            ]);
            $msg  = [
                'user'  =>  $customer['id'],
                'name'  =>  $customer['name'],
                'title' =>  'Welcome to ' . getenv('APP_NAME'),
                'body'  =>  "Please use this code to complete your registration: $token"
            ];
            $send = Mail::to($customer['email'])->send(new OtpVerificationMail($token, $user->name));
            return get_success_response(['message' => 'Please check your email for your verification code.'], 200);
        }
        return get_error_response(['errors' => [
            ['code' => 'not-found', 'message' => 'failed!']
        ]], 404);
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            return get_success_response($user);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        try {
            // check if reset token exists
            // $tokenExists = ResetToken::where(['email' => $request->email, 'token' => $request->token])->first();
            $user = User::whereEmail($request->email)->first();
            if ($user) {
                $user->password = bcrypt($request->password);
                $user->save();
                return get_success_response(['succes', "Password reset successfully"]);
            }
            return get_error_response(['error', "Invalid Email or token provided"], 404);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function forgotPassword(Request $request)
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

            //$user->notify(new PasswordResetNotification($token));
          	Mail::to($user->email)->send(new OtpVerificationMail($token, $user->username));

            return get_success_response(['msg' => 'Please check your email for your reset token']);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function updateProfileImage(Request $request)
    {
        try {
            $request->validate([
                'profile_image' => 'required|file|mimes:jpeg,png,gif,heic,heif,jpg'
            ]);

            $user = $request->user();
            $username = $user->username;
            if($imageUrl = save_image($request->profile_image, "profile-image/$username")) {
                $user->profile_image = $imageUrl;
                return get_success_response($imageUrl);
            }
            return get_error_response(["error" => "we're currently unable to process your request, try again later"]);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function usernameCheck($username)
    {
        try {
            $user = getUserByUsername($username);
            if($user != false) {
                return get_success_response($user);
            }

            return get_error_response(['error' => "User with the provided username does not exists"]);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }
}
