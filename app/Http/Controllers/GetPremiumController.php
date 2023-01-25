<?php

namespace App\Http\Controllers;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Http\Request;

class GetPremiumController extends Controller
{
    public function index() {
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "10.00" // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Order #12345",
            "redirectUrl" => route('getpremium.success'),
            "webhookUrl" => route('webhooks.mollie'),
            "metadata" => [
                "order_id" => "12345",
            ],
        ]);

        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function success() {
        return view('getpremiumsuccess');
    }

    public function handle(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);

        if ($payment->isPaid()) {
            // Set user to premium
            $user = auth()->user();
            $user->rainbow = true;
            $user->save();
        }
    }
}
