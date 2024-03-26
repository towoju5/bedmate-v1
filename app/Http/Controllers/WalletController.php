<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public $currencies;

    public function __construct()
    {
        $this->currencies = ["USD", "NGN"];
    }

    /**
     * Get current user wallet balance
     */
    public function balance()
    {
        try {
            $currencies = $this->currencies;
            $user = auth()->user();
            $balance = [];
            foreach ($currencies as $key => $curr) {
                if($user->hasWallet($curr)) {
                    $balance[$curr] = $user->wallet->refreshBalance();
                }
            }
            return get_success_response($balance);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    /**
     * Convert currency from one wallet balance to another
     */
    public function exchange(Request $request)
    {
        try {
            $validate = $request->validate([
                'from_currency' => 'required',
                'to_currency'   => 'required',
                'amount'        =>  'required'
            ]);

            $user = auth()->user();

            if(!$user->hasWallet($request->from_currency)) {
                return get_error_response(['error' => "Invalid from currency provided"]);
            }

            if(!$user->hasWallet($request->to_currency)) {
                return get_error_response(['error' => "Invalid to currency provided"]);
            }

            $from_currency = $user->getWallet($request->from_currency);
            $to_currency = $user->getWallet($request->to_currency);

            $transfer = $from_currency->exchange($to_currency, 10000);
            
            $result = [
                $request->to_currency = $to_currency->balance,
                $request->from_currency = $from_currency->balance
            ];

            return get_success_response($balance);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function addWallet(Request $request)
    {
        try {
            $currency = [
                'name' => 'Nigeria Naira',
                'slug' => 'ngn',
                'meta' => [
                    "icon" => "₦",
                    "type" => "fiat",
                    "precision" => 2
                ],
            ];
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage]);
        }
    }
    
    public function deposit(Request $request)
    {
        try {
            $request->validate(
                [
                    'amount' => 'required',
                    'currency'=> 'required'
                ]
            );

            $validate['user_id'] = auth()->id();
            
            $api_call = Http::withToken()->post(getenv('DEPOSIT_URL'),  $validate)->json();

            // return $api_call
            return get_success_response($api_call);
        } catch (\Throwable $th) {
            get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function withdrawal()
    {
        //
    }

    public function payoutQuote(Request $request)
    {
        //
    }

    public function getRequirements(Request $request)
    {
        try {
            $request->validate([
                'currency'  => 'required',
                'country'   => 'required',
            ]);

        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }
}
