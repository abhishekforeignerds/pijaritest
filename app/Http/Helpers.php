<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Upload;
use GuzzleHttp\Client;
use App\Models\AppSetup;
use Illuminate\Support\Str;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;

if (!function_exists('commissions')) {
    function commissions()
    {
        return [
            100, 50, 30, 20, 15, 10, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5
        ];
    }
}

if (!function_exists('findRange')) {
    function findRange($value)
    {
        $rangeList = ['0-49.99', '50-99.99', '100-499.99', '500-999.99', '1000-4999.99', '5000-9999.99', '10000-14999.99', '15000-29999.99', '30000-49999.99', '50000-99999.99', '100000-499999.99', '500000-999999.99', '1000000-above'];
        $rangeResult = findRangeValue($value, $rangeList);
        if ($rangeResult !== null) {
            return $rangeResult;
        } else {
            return 0;
        }
    }
}

if (!function_exists('findRangeValue')) {
    function findRangeValue($value, $ranges)
    {
        $slab_percentage = ['30', '40', '44', '47', '50', '53', '56', '59', '62', '64', '66', '68', '70'];

        foreach ($ranges as $key => $range) {
            if (is_int($range)) {
                if ($value === $range) {
                    return $slab_percentage[$key];
                }
            } elseif (is_string($range)) {
                [$start, $end] = explode('-', $range);
                if ($start <= $value && $value <= $end) {
                    return $slab_percentage[$key];
                }
            }
        }
        return null;
    }
}

if (!function_exists('findDesignationRange')) {
    function findDesignationRange($value)
    {
        $rangeList = [30, 40, 44, 47, 50, 53, 56, 59, 62, 64, 66, 68, 70];
        $rangeResult = findDesignationValue($value, $rangeList);
        if ($rangeResult !== null) {
            return $rangeResult;
        } else {
            return 0;
        }
    }
}

if (!function_exists('findDesignationValue')) {
    function findDesignationValue($value, $ranges)
    {
        $slab_percentage = ['member', 'bronze', 'purle', 'star', 'silver', 'gold', 'platinum', 'rubey', 'sapphire', 'director', 'emerald_director', 'diamond_director', 'crown_director'];

        foreach ($ranges as $key => $range) {
            if (is_int($range)) {
                if ($value == $range) {
                    return $slab_percentage[$key];
                }
            } elseif (is_string($range)) {
                [$start, $end] = explode('-', $range);
                if ($start <= $value && $value <= $end) {
                    return $slab_percentage[$key];
                }
            }
        }
        return null;
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = BusinessSetting::where('type', $key)->first();
        return $setting == null ? $default : $setting->value;
    }
}

if (!function_exists('compress')) {
    function compress($src, $dist, $dis_width = 500)
    {
        $img = '';
        $extension = strtolower(strrchr($src, '.'));
        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                $img = imagecreatefromjpeg($src);
                break;
            case '.gif':
                $img = imagecreatefromgif($src);
                break;
            case '.png':
                $img = imagecreatefrompng($src);
                imagealphablending($img, false);
                imagesavealpha($img, true);
                break;
        }
        $width = imagesx($img);
        $height = imagesy($img);
        $dis_height = $dis_width * ($height / $width);
        $new_image = imagecreatetruecolor($dis_width, $dis_height);
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
        imagecopyresampled($new_image, $img, 0, 0, 0, 0, $dis_width, $dis_height, $width, $height);
        $imageQuality = 90;
        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($new_image, $dist, $imageQuality);
                }
                break;
            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($new_image, $dist);
                }
                break;
            case '.png':
                $scaleQuality = round(($imageQuality / 100) * 9);
                $invertScaleQuality = 9 - $scaleQuality;
                if (imagetypes() & IMG_PNG) {
                    imagepng($new_image, $dist, $invertScaleQuality);
                }
                break;
        }
        imagedestroy($new_image);
        return filesize($src);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return $root;
    }
}

if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return env('AWS_URL') . '/';
        } else {
            return getBaseURL() . 'public/';
        }
    }
}

if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = \App\Models\Upload::find($id)) != null) {
            return my_asset($asset->file_name);
        }
        return null;
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        return app('url')->asset('/' . $path, $secure);
    }
}

if (!function_exists('upload_file')) {
    function upload_file($request, $name, $is_compress=false)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );
        if ($request->hasFile($name)) {


            $upload = new Upload;
            $upload->file_original_name = null;

            $arr = explode('.', $request->file($name)->getClientOriginalName());

            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($i == 0) {
                    $upload->file_original_name .= $arr[$i];
                } else {
                    $upload->file_original_name .= "." . $arr[$i];
                }
            }

            if (!empty(Auth::guard('admin')->user()->id)) {
                $upload->user_id = Auth::guard('admin')->user()->id;
            }
            if (!empty(Auth::guard('pujari')->user()->id)) {
                $upload->user_id = Auth::guard('pujari')->user()->id;
            }
            $fileName = Str::uuid() . '.' . $request->file($name)->getClientOriginalName();
            $upload->extension = $request->file($name)->getClientOriginalExtension();
            if (isset($type[$upload->extension])) {
                $upload->type = $type[$upload->extension];
            } else {
                $upload->type = "others";
            }
            $upload->file_size = $request->file($name)->getSize();
            $request->file($name)->move(public_path('uploads/all'), $fileName);
            if($is_compress){
                if ($upload->file_size >= 102400) {

                    if ($upload->extension == 'jpg' || $upload->extension == 'jpeg' || $upload->extension == 'png' || $upload->extension == 'svg' || $upload->extension == 'webp') {

                        $src = "uploads/all/" . $fileName;
                        $upload->file_size = compress($src, $src, 500, $fileName);
                    }
                }
            }
            $upload->file_name = 'uploads/all/' . $fileName;
            $upload->save();

            return  $upload->id;
        }
    }
}

if (!function_exists('upload_single_file')) {
    function upload_single_file($file)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );
        if ($file) {


            $upload = new Upload;
            $upload->file_original_name = null;

            $arr = explode('.', $file->getClientOriginalName());

            for ($i = 0; $i < count($arr) - 1; $i++) {
                if ($i == 0) {
                    $upload->file_original_name .= $arr[$i];
                } else {
                    $upload->file_original_name .= "." . $arr[$i];
                }
            }

            if (!empty(Auth::guard('admin')->user()->id)) {
                $upload->user_id = Auth::guard('admin')->user()->id;
            }
            // if (!empty(Auth::guard('vendor')->user()->id)) {
            //     $upload->user_id = Auth::guard('vendor')->user()->id;
            // }

            $fileName = Str::uuid() . '.' . $file->getClientOriginalName();
            $upload->extension = $file->getClientOriginalExtension();
            if (isset($type[$upload->extension])) {
                $upload->type = $type[$upload->extension];
            } else {
                $upload->type = "others";
            }
            $upload->file_size = $file->getSize();
            $file->move(public_path('uploads/all'), $fileName);
            if ($upload->file_size >= 102400) {

                if ($upload->extension == 'jpg' || $upload->extension == 'jpeg' || $upload->extension == 'png' || $upload->extension == 'svg' || $upload->extension == 'webp') {

                    $src = "uploads/all/" . $fileName;
                    $upload->file_size = compress($src, $src, 500, $fileName);
                }
            }
            $upload->file_name = 'uploads/all/' . $fileName;
            $upload->save();

            return  $upload->id;
        }
    }


    if (!function_exists('getTotalTeamCount')) {
        function getTotalTeamCount($userId)
        {
            $user = User::find($userId);
            $userIds = User::where('referral_by', $user->referral_code)->where('status',1)->get()->pluck('id');

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $teamCount = calculateTotalTeamCount($user);

            return $teamCount;
        }
    }

    if (!function_exists('calculateTotalTeamCount')) {
        function calculateTotalTeamCount($user)
        {
            $teamCount = 0;

            foreach (User::where('referral_by', $user->referral_code)->get() as $child) {
                if ($child->status == 1) {
                    $teamCount++; // Count the direct children
                }
                $teamCount += calculateTotalTeamCount($child); // Recursively count their teams
            }

            return $teamCount;
        }
    }

    if (!function_exists('getTotalTeamIACount')) {
        function getTotalTeamIACount($userId)
        {
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $teamCount = calculateTotalTeamIACount($user);

            return $teamCount;
        }
    }

    if (!function_exists('calculateTotalTeamIACount')) {
        function calculateTotalTeamIACount($user)
        {
            $teamCount = 0;

            foreach (User::where('referral_by', $user->referral_code)->get() as $child) {
                if ($child->status == 0) {
                    $teamCount++; // Count the direct children
                }
                $teamCount += calculateTotalTeamIACount($child); // Recursively count their teams
            }

            return $teamCount;
        }
    }

    if (!function_exists('razorpay_payout_bank')) {
        function razorpay_payout_bank($user, $amount)
        {
            $amount = $amount * 100;
            $curl = curl_init();

            $data = [
                "account_number" => env('ACCOUNT_NUMBER'),
                "amount" => $amount,
                "currency" => "INR",
                "mode" => "NEFT",
                "purpose" => "payout",
                "fund_account" => [
                    "account_type" => "bank_account",
                    "bank_account" => [
                        "name" => $user->user_kyc->account_holder_name,
                        "ifsc" => $user->user_kyc->ifsc_code,
                        "account_number" => $user->user_kyc->account_number,
                    ],
                    "contact" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "contact" => $user->phone,
                        "type" => "customer",
                        "reference_id" => "",
                        "notes" => [
                            "notes_key_1" => "Tea, Earl Grey, Hot",
                            "notes_key_2" => "Tea, Earl Grey… decaf."
                        ]
                    ]
                ],
                "queue_if_low_balance" => true,
                "reference_id" => "Acme Transaction ID 12345",
                "narration" => "Acme Corp Fund Transfer",
                "notes" => [
                    "notes_key_1" => "Beam me up Scotty",
                    "notes_key_2" => "Engage"
                ]
            ];

            $encodedData = json_encode($data);


            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.razorpay.com/v1/payouts',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $encodedData,
                CURLOPT_USERPWD => env('R_KEY').":".env('R_SECRET'),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }
    }

    if (!function_exists('razorpay_payout_upi')) {
        function razorpay_payout_upi($user, $amount)
        {
            $curl = curl_init();

            $data = [
                "account_number" =>env('ACCOUNT_NUMBER'),
                "amount" => $amount * 100,
                "currency" => "INR",
                "mode" => "UPI",
                "purpose" => "payout",
                "fund_account" => [
                    "account_type" => "vpa",
                    "vpa" => [
                        "address" => $user->user_kyc->upi_id,
                    ],
                    "contact" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "contact" => $user->phone,
                        "type" => "customer",
                        "reference_id" => "Acme Contact ID 12345",
                        "notes" => [
                            "notes_key_1" => "Tea, Earl Grey, Hot",
                            "notes_key_2" => "Tea, Earl Grey… decaf."
                        ]
                    ]
                ],
                "queue_if_low_balance" => true,
                "reference_id" => "Acme Transaction ID 12345",
                "narration" => "Acme Corp Fund Transfer",
                "notes" => [
                    "notes_key_1" => "Beam me up Scotty",
                    "notes_key_2" => "Engage"
                ]
            ];

            $encodedData = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.razorpay.com/v1/payouts',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $encodedData,
                CURLOPT_USERPWD => env('R_KEY').":".env('R_SECRET'),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }
    }

    if (!function_exists('vendor_razorpay_payout_bank')) {
        function vendor_razorpay_payout_bank($user, $amount)
        {
            $amount = $amount * 100;
            $curl = curl_init();

            $data = [
                "account_number" =>env('ACCOUNT_NUMBER'),
                "amount" => $amount,
                "currency" => "INR",
                "mode" => "NEFT",
                "purpose" => "payout",
                "fund_account" => [
                    "account_type" => "bank_account",
                    "bank_account" => [
                        "name" => $user->account_holder_name,
                        "ifsc" => $user->ifsc_code,
                        "account_number" => $user->account_number,
                    ],
                    "contact" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "contact" => $user->phone,
                        "type" => "customer",
                        "reference_id" => "",
                        "notes" => [
                            "notes_key_1" => "Tea, Earl Grey, Hot",
                            "notes_key_2" => "Tea, Earl Grey… decaf."
                        ]
                    ]
                ],
                "queue_if_low_balance" => true,
                "reference_id" => "Acme Transaction ID 12345",
                "narration" => "Acme Corp Fund Transfer",
                "notes" => [
                    "notes_key_1" => "Beam me up Scotty",
                    "notes_key_2" => "Engage"
                ]
            ];

            $encodedData = json_encode($data);


            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.razorpay.com/v1/payouts',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $encodedData,
                CURLOPT_USERPWD => env('R_KEY').":".env('R_SECRET'),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }
    }

    if (!function_exists('vendor_razorpay_payout_upi')) {
        function vendor_razorpay_payout_upi($user, $amount)
        {
            $curl = curl_init();

            $data = [
                "account_number" =>env('ACCOUNT_NUMBER'),
                "amount" => $amount * 100,
                "currency" => "INR",
                "mode" => "UPI",
                "purpose" => "payout",
                "fund_account" => [
                    "account_type" => "vpa",
                    "vpa" => [
                        "address" => $user->upi_id,
                    ],
                    "contact" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "contact" => $user->phone,
                        "type" => "customer",
                        "reference_id" => "Acme Contact ID 12345",
                        "notes" => [
                            "notes_key_1" => "Tea, Earl Grey, Hot",
                            "notes_key_2" => "Tea, Earl Grey… decaf."
                        ]
                    ]
                ],
                "queue_if_low_balance" => true,
                "reference_id" => "Acme Transaction ID 12345",
                "narration" => "Acme Corp Fund Transfer",
                "notes" => [
                    "notes_key_1" => "Beam me up Scotty",
                    "notes_key_2" => "Engage"
                ]
            ];

            $encodedData = json_encode($data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.razorpay.com/v1/payouts',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $encodedData,
                CURLOPT_USERPWD => env('R_KEY').":".env('R_SECRET'),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }
    }

    if(!function_exists('status_check_api')){
        function status_check_api($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.razorpay.com/v1/payouts/'.$id,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic cnpwX2xpdmVfUDhScXJib1ZRUk1zblQ6QWFRNzlQVkd6Q3B0RmtaYVpMTVU5cGsy'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
      }
    }

    if (!function_exists('appSetupValue')) {
        function AppSetupValue($name) {
            return AppSetup::where('name', $name)->first() ? AppSetup::where('name', $name)->first()->value : "";
        }
    }

    if (!function_exists('checkout_done')) {
        function checkout_done($order_id, $payment)
        {
            $order = Order::find($order_id);
            $order->payment_status = 'paid';
            $order->payment_details = $payment;
            $order->save();
        }
     }


     if (!function_exists('order_confirmed_sms')) {
        function order_confirmed_sms($mobile_no,$name,$order_id)
        {

                $url="http://msg.msgclub.net/rest/services/sendSMS/sendTemplate?AUTH_KEY=953c1b58f56e96729da91a7997a8d&senderId=SAPLPU&routeId=1&mobileNos=".$mobile_no."&templateid=1707171906060306368&var1=".$name."&var2=".$order_id;

                // init the resource
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0
                ));

                //get response
                $output = curl_exec($ch);
                //Print error if any
                if(curl_errno($ch))
                {
                    echo 'error:' .curl_error($ch);
                }
                curl_close($ch);
                return $output;
            }
        }

    if (!function_exists('login_by_sms')) {
            function login_by_sms($mobile_no,$otp)
            {

                    $url="http://msg.msgclub.net/rest/services/sendSMS/sendTemplate?AUTH_KEY=953c1b58f56e96729da91a7997a8d&senderId=SAPLPU&routeId=1&mobileNos=".$mobile_no."&templateid=1707169951708685976&var1=".$otp;

                    // init the resource
                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => 0
                    ));

                    //get response
                    $output = curl_exec($ch);
                    //Print error if any
                    if(curl_errno($ch))
                    {
                        echo 'error:' .curl_error($ch);
                    }
                    curl_close($ch);
                    return $output;
                }
        }

    if(! function_exists('getLatLongFromPlaceId')){
        function getLatLongFromPlaceId($placeId)
        {
            $apiKey = env('GOOGLE_PLACES_API_KEY');
            $client = new Client();

            $response = $client->get('https://maps.googleapis.com/maps/api/place/details/json', [
                'query' => [
                    'place_id' => $placeId,
                    'key' => $apiKey,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $location = $data['result']['geometry']['location'];
            return (object)[
                'latitude'  => $location['lat'],
                'longitude' => $location['lng'],
            ];
        }
    }

    if(! function_exists('getPlanets')){
        function getPlanets($key)
        {
            $planets = [
                1 => [
                    'key'   => 'Sun',
                    'name'  => trans('lang.sun'),
                    'icon' => asset('frontend/images/sun.png')
                ],
                2 => [
                    'key'   => 'Moon',
                    'name'  => trans('lang.moon'),
                    'icon' => asset('frontend/images/moon.png')
                ],
                3 => [
                    'key'   => 'Mercury',
                    'name'  => trans('lang.mercury'),
                    'icon' => asset('frontend/images/mercury.png')
                ],
                4 => [
                    'key'   => 'Venus',
                    'name'  => trans('lang.venus'),
                    'icon' => asset('frontend/images/venus.png')
                ],
                5 => [
                    'key'   => 'Mars',
                    'name'  => trans('lang.mars'),
                    'icon' => asset('frontend/images/mars.png')
                ],
                6 => [
                    'key'   => 'Saturn',
                    'name'  => trans('lang.saturn'),
                    'icon' => asset('frontend/images/saturn.png')
                ],
                7 => [
                    'key'   => 'Jupiter',
                    'name'  => trans('lang.jupiter'),
                    'icon' => asset('frontend/images/jupiter.png')
                ],
                8 => [
                    'key'   => 'Rahu',
                    'name'  => trans('lang.rahu'),
                    'icon' => asset('frontend/images/space.png')
                ],
                9 => [
                    'key'   => 'Ketu',
                    'name'  => trans('lang.ketu'),
                    'icon' => asset('frontend/images/ketu.png')
                ]

            ];

            return $planets[$key];
        }
    }

    if(! function_exists('getHoroscopes')){
        function getHoroscopes($key)
        {
            $horoscopes_arr = [
                1 => [
                    'name' => trans('lang.aries'),
                    'icon' => asset('frontend/images/h1.png')
                ],
                2 => [
                    'name' => trans('lang.taurus'),
                    'icon' => asset('frontend/images/h2.png')
                ],
                3 => [
                    'name' => trans('lang.gemini'),
                    'icon' => asset('frontend/images/h3.png')
                ],
                4 => [
                    'name' => trans('lang.cancer'),
                    'icon' => asset('frontend/images/h4.png')
                ],
                5 => [
                    'name' => trans('lang.leo'),
                    'icon' => asset('frontend/images/h5.png')
                ],
                6 => [
                    'name' => trans('lang.virgo'),
                    'icon' => asset('frontend/images/h6.png')
                ],
                7 => [
                    'name' => trans('lang.libra'),
                    'icon' => asset('frontend/images/h7.png')
                ],
                8 => [
                    'name' => trans('lang.scorpio'),
                    'icon' => asset('frontend/images/h8.png')
                ],
                9 => [
                    'name' => trans('lang.sagittairus'),
                    'icon' => asset('frontend/images/h9.png')
                ],
                10 => [
                    'name' => trans('lang.capricorn'),
                    'icon' => asset('frontend/images/h10.png')
                ],
                11 => [
                    'name' => trans('lang.aquarius'),
                    'icon' => asset('frontend/images/h11.png')
                ],
                12 => [
                    'name' => trans('lang.pisces'),
                    'icon' => asset('frontend/images/h12.png')
                ]
            ];

            return $horoscopes_arr[$key];
        }
    }
}
