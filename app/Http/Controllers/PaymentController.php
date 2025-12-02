<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function print($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        return view('printpayment', compact('payment'));
    }
}
