<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerDetail;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay_success(Request $request)
    {

        $customer_detail = CustomerDetail::where('customer_id', $request->customer_id)->first();

        $customer_detail->payment_status = 1;
        $customer_detail->update();

        $tax = Setting::where('setting_key', 'gst')->first();

        $transaction                 = new Transaction();
        $transaction->transaction_id = $request->razorpay_payment_id;
        $transaction->user_id        = $request->customer_id;
        $transaction->amount         = $request->passingAmount;
        $transaction->tax            = $request->passingAmount * ($tax->value / 100);
        $transaction->total_amount   = $transaction->amount + $transaction->tax;
        $transaction->payment_type   = 1;
        $transaction->save();

        $arr = array('msg' => 'Payment successful.', 'status' => true);
        return Response()->json($arr);
    }
}
