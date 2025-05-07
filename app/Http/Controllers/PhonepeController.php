<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Session;
use Redirect;
use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;

class PhonepeController extends Controller
{

    public function payWithPhonePe($request)
    {
        $input = $request->all();
        session()->put('data', $input);
        Session::forget('mm_tid');
        $order_id = date('Ymd-His') . rand(10, 99);
        $merchantTransaction = "MT" . $order_id;
        $grand_total = $request->amount;
        Session::put('mm_tid', $merchantTransaction);
        $data =  $this->payload_creation($grand_total, $request->phone, $merchantTransaction);

        if($request->type=='customer_registration_fees'){
            $payment = new PaymentTransaction;
            $payment->user_id = Auth::user()->id;
            $payment->transaction_type = 'customer_registration_fess';
            $payment->user_type = 'user';
            $payment->amount = $request->amount;
            $payment->payment_method = 'phonepe';
            $payment->payment_details = '';
            $payment->status = 'initiated';
            $payment->mt_id = $merchantTransaction;
            $payment->save();
        }

        if($request->type=='vendor_product_recharge'){
            $payment = new PaymentTransaction;
            $payment->user_id =Auth::guard('vendor')->user()->id;
            $payment->transaction_type = 'vendor_product_recharge';
            $payment->user_type = 'vendor';
            $payment->amount = $request->amount;
            $payment->payment_method = 'phonepe';
            $payment->payment_details = '';
            $payment->status = 'initiated';
            $payment->mt_id = $merchantTransaction;
            $payment->save();
        }

        if($request->type=='vendor_service_recharge'){
            $payment = new PaymentTransaction;
            $payment->user_id = Auth::guard('vendor')->user()->id;
            $payment->transaction_type = 'vendor_service_recharge';
            $payment->user_type = 'vendor';
            $payment->amount = $request->amount;
            $payment->payment_method = 'phonepe';
            $payment->payment_details = '';
            $payment->status = 'initiated';
            $payment->mt_id = $merchantTransaction;
            $payment->save();
        }


        if($request->type=='customer_order'){
            $payment = new PaymentTransaction;
            $payment->user_id = Auth::user()->id;
            $payment->transaction_type = 'customer_order';
            $payment->user_type = 'user';
            $payment->amount = $request->amount;
            $payment->payment_method = 'phonepe';
            $payment->payment_details = '';
            $payment->status = 'initiated';
            $payment->mt_id = $merchantTransaction;
            $payment->save();
        }

        if($request->type=='vendor_registration_fee'){
            $payment = new PaymentTransaction;
            $payment->user_id = Auth::guard('vendor')->user()->id;
            $payment->transaction_type = 'vendor_registration_fee';
            $payment->user_type = 'vendor';
            $payment->amount = $request->amount;
            $payment->payment_method = 'phonepe';
            $payment->payment_details = '';
            $payment->status = 'initiated';
            $payment->mt_id = $merchantTransaction;
            $payment->save();
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode(['request' => $data['payload']]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-VERIFY:" . $data['base_hash'],
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $payment_response = json_decode($response)->data;
            return $payment_response->instrumentResponse->redirectInfo->url;
        }
    }


    public function payload_creation($amount, $phone, $merchantTransaction)
    {
        $payload = array(
            "merchantId" => 'GENIALONLINE',
            "merchantTransactionId" => $merchantTransaction,
            "merchantUserId" => "MUID" . rand(1111, 9999),
            "amount" => $amount * 100,
            "redirectUrl" => route('phonepe.redirectUrl'),
            "redirectMode" => "GET",
            "callbackUrl" => route('phonepe.callback'),
            "mobileNumber" => $phone,
            "paymentInstrument" => ["type" => "PAY_PAGE"],
        );

        $payload_json = json_encode($payload);
        $base64_payload = base64_encode($payload_json);



        $salt = '206b3f12-b667-4ebe-959c-30d35bfa5c9c'; // replace with your actual salt key

        $hash_input = $base64_payload . "/pg/v1/pay" . $salt;

        $sha256_hash = hash('sha256', $hash_input) . '###1';
        return ['payload' => $base64_payload, 'base_hash' => $sha256_hash];
    }

    public function callback(Request $request)
    {
        $response = base64_decode($request);
        $data = json_decode($response);
        return $data;
    }

    public function redirectUrl(Request $request)
    {
        $data = $this->status_check_api();
        $response_data = json_decode($data);
        if (!empty($response_data->success)) {
            if (($response_data->success == true) && ($response_data->code=='PAYMENT_SUCCESS') ) {
                $input = session()->get('data');
                session()->forget('data');
                session()->forget('mm_tid');

                if($input['type']=='vendor_product_recharge'){
                    $request->merge(['category_id' => $input['category_id'],'type'=>$input['type'],'amount'=>$input['amount'],'payment_details'=>$data]);
                    $vendor = new VendorController;
                    return $vendor->vendor_categories_product_fess($request);
                }
                if($input['type']=='vendor_service_recharge'){
                    $request->merge(['category_id' => $input['category_id'],'type'=>$input['type'],'amount'=>$input['amount'],'payment_details'=>$data]);
                    $vendor = new VendorController;
                    return $vendor->vendor_categories_service_fess($request);
                }
                if($input['type']=='customer_order'){
                    $request->merge(['address_id' => $input['address_id'],'type'=>$input['type'],'payment_option'=>$input['payment_option'],'payment_details'=>$data]);
                    $vendor = new OrderController;
                    return $vendor->process_order($request);
                }
                if($input['type']=='vendor_registration_fee'){
                    $request->merge(['type'=>$input['type'],'topup_category'=>$input['topup_category'],'registration_fee'=>$input['registration_fee'],'payment_details'=>$data,'amount'=>$input['amount']]);
                    $vendor = new VendorController;
                    return $vendor->vendor_registration_fess($request);
                }
                if($input['type']=='customer_registration_fees'){
                    $request->merge(['type'=>$input['type'],'amount'=>$input['amount'],'payment_details'=>$data]);
                    $customer = new CustomerController;
                    return $customer->pay($request);
                }
            }else {
               // dd($response_data);
                $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
                $payment->status = 'failed';
                $payment->save();

                session()->forget('data');
                session()->forget('mm_tid');


                return redirect('/')->with('error', 'You Payment Is Cancel!');
            }
        }else {
                $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
                $payment->status = 'failed';
                $payment->save();

                session()->forget('data');
                session()->forget('mm_tid');
                return redirect('/')->with('error', 'You Payment Is Cancel!');
        }
    }


    public function payload_creation_status_check()
    {
        $salt = '206b3f12-b667-4ebe-959c-30d35bfa5c9c'; // replace with your actual salt key

        $hash_input = "/pg/v1/status/GENIALONLINE/".session()->get('mm_tid').$salt;

        $sha256_hash = hash('sha256', $hash_input).'###1';
        return $sha256_hash;
    }

    public function status_check_api()
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/status/GENIALONLINE/".session()->get('mm_tid'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-MERCHANT-ID: GENIALONLINE",
                "X-VERIFY: ".$this->payload_creation_status_check(),
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function payload_creation_status_check_manual($id)
    {
        $salt = '206b3f12-b667-4ebe-959c-30d35bfa5c9c'; // replace with your actual salt key

        $hash_input = "/pg/v1/status/GENIALONLINE/".$id.$salt;

        $sha256_hash = hash('sha256', $hash_input).'###1';
        return $sha256_hash;
    }

    public function status_check_api_manual($id)
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/status/GENIALONLINE/".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-MERCHANT-ID: GENIALONLINE",
                "X-VERIFY: ".$this->payload_creation_status_check_manual($id),
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function updatePayment(Request $request)
    {
        $data = $this->status_check_api_manual($request->id);
        $response_data = json_decode($data);
        if (!empty($response_data->success)) {
            if (($response_data->success == true) && ($response_data->code=='PAYMENT_SUCCESS') ) {
                $input = session()->get('data');
                session()->forget('data');
                session()->forget('mm_tid');

                if($input['type']=='vendor_product_recharge'){
                    $request->merge(['category_id' => $input['category_id'],'type'=>$input['type'],'amount'=>$input['amount'],'payment_details'=>$data]);
                    $vendor = new VendorController;
                    return $vendor->vendor_categories_product_fess($request);
                }
                if($input['type']=='vendor_service_recharge'){
                    $request->merge(['category_id' => $input['category_id'],'type'=>$input['type'],'amount'=>$input['amount'],'payment_details'=>$data]);
                    $vendor = new VendorController;
                    return $vendor->vendor_categories_service_fess($request);
                }
                if($input['type']=='customer_order'){
                    $request->merge(['address_id' => $input['address_id'],'type'=>$input['type'],'payment_option'=>$input['payment_option'],'payment_details'=>$data]);
                    $vendor = new OrderController;
                    return $vendor->process_order($request);
                }
                if($input['type']=='vendor_registration_fee'){
                    $request->merge(['type'=>$input['type'],'topup_category'=>$input['topup_category'],'registration_fee'=>$input['registration_fee'],'payment_details'=>$data,'amount'=>$input['amount']]);
                    $vendor = new VendorController;
                    return $vendor->vendor_registration_fess($request);
                }
                if($input['type']=='customer_registration_fees'){
                    $request->merge(['type'=>$input['type'],'amount'=>$input['amount'],'payment_details'=>$data]);
                    $customer = new CustomerController;
                    return $customer->pay($request);
                }
            }else {
               // dd($response_data);
                $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
                $payment->status = 'failed';
                $payment->save();

                session()->forget('data');
                session()->forget('mm_tid');


                return redirect('/')->with('error', 'You Payment Is Cancel!');
            }
        }else {
                $payment = PaymentTransaction::where('mt_id',$response_data->data->merchantTransactionId)->first();
                $payment->status = 'failed';
                $payment->save();

                session()->forget('data');
                session()->forget('mm_tid');
                return redirect('/')->with('error', 'You Payment Is Cancel!');
        }
    }


}
