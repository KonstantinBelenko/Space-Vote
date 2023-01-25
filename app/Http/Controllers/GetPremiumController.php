<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Http\Request;

class GetPremiumController extends Controller
{
    public function index() {
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "100.00",
            ],
            "description" => 'Rainbow for ' . auth()->user()->name,
            "redirectUrl" => route('getpremium.success'),
            "webhookUrl" => route('mollie-webhook'),
            "metadata" => [
                "user_id" => auth()->id(),
                "order_id" => Str::uuid(),
            ],
        ]);

        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function success(Request $request) {
        $payment = Mollie::api()->payments()->get($request->paymentId);
        if ($payment->isPaid()) {
            auth()->user()->update([
                'premium' => true,
            ]);
            return view('getpremiumsuccess');
        }
    }

    public function webhook(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);
        if ($payment->isPaid()) {
            // Set user to premium
            $user = \App\Models\User::find($payment->metadata->user_id);
            $user->update([
                'rainbow' => true,
            ]);
        }
    }
}
