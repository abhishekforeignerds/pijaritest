<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Redirect;
use App\Http\Controllers\Controller;

class PhonepeController extends Controller
{
    public function pay(Request $request)
    {
        $paymentType = $request->payment_type;
        $merchantUserId = $request->user_id;
        $amount = $request->grand_total;
        $userId = $request->user_id;

        if ($paymentType == 'phonepe') {
            $combined_order = Order::find($request->order_id);
            $amount = $combined_order->grand_total;
            $merchantTransactionId = $paymentType . '-' . $combined_order->id . '-' . $userId . '-' . rand(0, 100000);
        }
        // $merchantTransactionId = "MT7850590068188104";
        $merchantId = env('PHONEPE_MERCHANT_ID');
        $salt_key = env('PHONEPE_SALT_KEY');
        $salt_index = env('PHONEPE_SALT_INDEX');


        $base_url = "https://api.phonepe.com/apis/hermes/pg/v1/pay";

        $post_field = [
            'merchantId' => $merchantId,
            'merchantTransactionId' => $merchantTransactionId,
            'merchantUserId' => $merchantUserId,
            'amount' => $amount * 100,
            'redirectUrl' => route('api.phonepe.redirecturl'),
            'redirectMode' => 'POST',
            'callbackUrl' =>  route('api.phonepe.callbackUrl'),
            'mobileNumber' =>  "9999999999",
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ],
        ];
        $payload = base64_encode(json_encode($post_field));

        $hashedkey =  hash('sha256', $payload . "/pg/v1/pay" . $salt_key) . '###' . $salt_index;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $base_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-VERIFY: ' . $hashedkey . '',
            'accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "\n{\n  \"request\": \"$payload\"\n}\n");

        $response = curl_exec($ch);
        $res = (json_decode($response));
        // dd($res);
        return response()->json(['payment_url' => $res->data->instrumentResponse->redirectInfo->url]);
    }

    public function phonepe_redirecturl(Request $request)
    {
        $payment_type = explode("-", $request['transactionId']);

        if ($request['code'] == 'PAYMENT_SUCCESS') {
            return response()->json(['result' => true, 'message' => "Payment is successful"]);
        }
        return response()->json(['result' => false, 'message' =>"Payment is failed"]);
    }

    public function phonepe_callbackUrl(Request $request)
    {
        $res = $request->all();
        $response = $res['response'];
        $decodded_response = json_decode(base64_decode($response));

        $payment_type = explode("-", $decodded_response->data->merchantTransactionId);

        $amount = $decodded_response->data->amount / 100;
        if ($decodded_response->code  == 'PAYMENT_SUCCESS') {
            if ($payment_type[0] == 'phonepe') {
                checkout_done($payment_type[1], json_encode($decodded_response->data));
            }
        }
    }
}
