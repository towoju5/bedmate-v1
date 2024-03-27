<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class WalletController extends Controller
{
    public $currencies;

    public function __construct()
    {
        $this->currencies = ["GHS", "USD", "NGN", "ZAR", "KES"];
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
                    $balance[$curr] = $user->balance;
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
                'amount'        => 'required'
            ]);

            $user = User::find(auth()->id());
          	//$user->getWallet($request->from_currency)->deposit(100000);

            if(!$user->hasWallet($request->from_currency)) {
                return get_error_response(['error' => "Invalid from currency provided"]);
            }

            if(!$user->hasWallet($request->to_currency)) {
                return get_error_response(['error' => "Invalid to currency provided"]);
            }

            $from_currency = $user->getWallet($request->from_currency);
            $to_currency = $user->getWallet($request->to_currency);

            $transfer = $from_currency->exchange($to_currency, $request->amount);
            
            $result = [
                $request->to_currency => $to_currency->balance,
                $request->from_currency => $from_currency->balance
            ];

            return get_success_response($result);
        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
        }
    }

    public function addWallet(Request $request)
    {
        try {
            $validate = $request->validate([
                "currency" => "required|in:" . implode(",", $this->currencies)
            ]);

            $curr_name = '';
            $curr_icon = '';

            switch (strtoupper($request->currency)) {
                case 'GHS':
                    $curr_name = "Ghana cedis";
                    $curr_icon = "GH₵";
                    break;
                case 'NGN':
                    $curr_name = "Nigeria Naira";
                    $curr_icon = "₦";
                    break;
                case 'ZAR':
                    $curr_name = "South Africa Rand";
                    $curr_icon = "R";
                    break;
                case 'KES':
                    $curr_name = "Kenyan shillings";
                    $curr_icon = "KES";
                    break;
                default:
                    return get_error_response(['error' => "Unsupported currency provided"]);
            }

            $user = User::find(auth()->id());

            $currency = [
                'name' => $curr_name,
                'slug' => strtoupper($request->currency),
                'meta' => [
                    "icon" => $curr_icon,
                    "type" => "fiat",
                    "precision" => 2
                ],
            ];

            // Check if user has the wallet, if not, create one
            if (!$user->hasWallet($request->currency)) {
                $wallet = $user->createWallet($currency);
                return get_success_response(["msg" => "Wallet created successfully", "wallet" => $wallet]);
            }

            return get_error_response(['error' => "User already has a wallet for the provided currency"]);

        } catch (\Throwable $th) {
            return get_error_response(['error' => $th->getMessage()]);
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
