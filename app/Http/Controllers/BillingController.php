<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Cashier\Payment;

class BillingController extends Controller
{
    public function index (Request $request) {
        $user = auth()->user();
        try {
            $newSubscription = $user->newSubscription('main', '200global')->create($request->payment_method, ['email' => $user->email]);
        } catch ( IncompletePayment $exception ){
            return redirect()->back()->with(['error_message' => $exception->getMessage()]);
        }

        return redirect()->back();
    }

     public function payonce (Request $request) {
        $user = auth()->user();
        try {
        	$chargeonce = $user->charge(100000, $request->payment_method, ['currency' => 'aud'] );
        	echo '<pre>'; print_r($chargeonce); die;
        } catch ( IncompletePayment $exception ){
            return redirect()->back()->with(['error_message' => $exception->getMessage()]);
        }

        return redirect()->back();
    }
}
