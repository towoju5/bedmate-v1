<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function deposit(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required',
                'currency'=> 'required'
            ]);

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
