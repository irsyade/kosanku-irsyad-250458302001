<?php

namespace App\Http\Controllers;

use App\Models\Payment;

class UserPaymentController extends Controller
{
   public function print($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        return view('printpayment', compact('payment'));
    }
}
