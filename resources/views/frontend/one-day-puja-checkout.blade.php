@extends('frontend.layouts.app')
@section('content')
<div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        @if (session()->get('pooja_language') == 'English')
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">E-Puja</a></li>
            <li class="breadcrumb-item"><a href="#">Package </a></li>
            <li class="breadcrumb-item"> Checkout </li>
        </ul>
        @else
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">होम</a></li>
            <li class="breadcrumb-item"><a href="#">ई-पूजा</a></li>
            <li class="breadcrumb-item"><a href="#">पैकेज</a></li>
            <li class="breadcrumb-item">चेकआउट</li>
        </ul>
        @endif
    </div>
</div>
<style>
    .advance {
        display: none;
    }
</style>
<style>
    #partitioned,
    #partitioned_sms,
    #partitioned_email {
        padding-left: 15px;
        letter-spacing: 42px;
        border: 0;
        background-image: linear-gradient(to left, black 70%, rgba(255, 255, 255, 0) 0%);
        background-position: bottom;
        background-size: 50px 1px;
        background-repeat: repeat-x;
        background-position-x: 35px;
        width: 220px;
        min-width: 220px;
    }

    #divInner {
        left: 0;
        position: sticky;
        text-align: center;
    }

    #divOuter {
        width: 190px;
        overflow: hidden;
    }

    #divOuter label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
        margin-top: 5px;
        letter-spacing: 1px;
    }

    #partitioned-error {
        margin-top: 10px;
        color: red;
    }

    #phone-error,
    #name-error,
    #phone_check_error {
        margin-top: 5px;
        color: red;
    }

    .correct {
        color: green;
    }

    .error {
        color: red;
    }
</style>
@if (session()->get('pooja_language') == 'English')
<section>
    <div class="auto-container">
        <div class="section-cart">
            <form id="order_form" name="order_form">
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <h3>Name Of members participating in Puja</h3>
                        <div class="billing-details">
                            <div class="row">
                                @php $no_of_people=$carts[0]->package->no_of_people; @endphp
                                @for ($i = 1; $i <= $no_of_people; $i++) <div class="mb-2 col-md-6">
                                    <label for="checkuot-form-fname">Full Name Person
                                        {{ $i }}<span>*</span></label>
                                    <input type="text" name="name[]" id="name_{{ $i }}" class="form-control"
                                        placeholder="Full Name" required>
                            </div>
                            @endfor
                            <div class="clearfix"></div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-lname">Phone <span>*</span></label>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10" required>
                            </div>

                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-email">Alternate contact / Whatsapp (optional)
                                </label>
                                <input type="number" name="alternate_contact" id="alternate_contact"
                                    class="form-control" placeholder="Alternate contact / Whatsapp (optional)"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card otp-box">
                                <div class="form-group floating-label">
                                    <div id="sms_otp" style="display:none;" class="otp_send">
                                        <div class="single-form mt-3">
                                            <p class="text-center">An OTP has been sent to your phone</p>
                                            <div id="divOuter" class="m-auto">
                                                <div id="divInner">
                                                    <input id="partitioned_sms" name="check_otp" type="text"
                                                        maxlength="4"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        onKeyPress="if(this.value.length==4) return false;" required>
                                                </div>
                                            </div>
                                            <p id="otp_error_sms" class="otp_send" style="text-align:center;">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="mb-10">Sankalp Details</h3>
                    <div class="billing-details">
                        <div class="row">
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">Gotra (optional)</label>
                                <input type="text" name="gotra" id="gotra" class="form-control" value="Kasyap"
                                    placeholder="Kashyap">
                            </div>
                        </div>
                    </div>
                    @if ($carts[0]->product->prashad == 'yes')
                    <h3 class="mb-10 mt-3">Prashad Details</h3>
                    <div class="billing-details">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text">
                                <h4> Would you like to receive the Aashirwad box ? </h4>
                                <p>{{ $carts[0]->product->prashad_text }}</p>
                            </div>
                            <ul class="nav nav-pills custom-tab mb-3" id="pills-tab" role="tablist"
                                style="width:145px;">
                                <li class="nav-item" role="presentation">
                                    <input type="radio" class="nav-link" name="is_prasahd" id="pills-yes-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-yes" type="button" role="tab"
                                        aria-controls="pills-yes" aria-selected="false" onclick="add_required('yes')"
                                        value="yes" />
                                    Yes
                                </li>
                                <li class="nav-item mx-1 mx-lg-4" role="presentation">
                                    <input type="radio" class="nav-link active" name="is_prasahd" id="pills-no-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-no" type="button" role="tab"
                                        aria-controls="pills-no" aria-selected="false" onclick="add_required('no')"
                                        value="no" checked /> No
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade" id="pills-yes" role="tabpanel" aria-labelledby="pills-yes-tab">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <input type="number" name="pincode" id="pincode"
                                            class="form-control form-required" placeholder="Pin Code (Compulsory)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="city" id="city" class="form-control form-required"
                                            placeholder="City Name (Compulsory)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="state" id="state" class="form-control form-required"
                                            placeholder="State Name (Compulsory)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="house_no" id="house_no"
                                            class="form-control form-required"
                                            placeholder="House no./ Building name (Compulsory)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="area" id="area" class="form-control form-required"
                                            placeholder="Road no./ Area / Colony (Compulsory)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="landmark" id="landmark"
                                            class="form-control form-required" placeholder="Landmark (Compulsory)">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-no" role="tabpanel" aria-labelledby="pills-no-tab">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Dakshina to Pandit</h4>
                            <div class="dakshina-tab">
                                <ul class="nav nav-pills custom-tab mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item me-3" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true" onclick="set_amount(51)">
                                            <i class="fas fa-rupee-sign"></i>
                                            51
                                        </button>
                                    </li>
                                    <li class="nav-item me-3" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false"
                                            onclick="set_amount(101)">
                                            <i class="fas fa-rupee-sign"></i>
                                            101
                                        </button>
                                    </li>
                                    <li class="nav-item me-3" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false"
                                            onclick="set_amount(201)">
                                            <i class="fas fa-rupee-sign"></i>
                                            201
                                        </button>
                                    </li>
                                </ul>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="number" name="dakshina" id="dakshina"
                                            class="form-control form-required" placeholder="" value="0"
                                            oninput="this.value = Math.abs(this.value)"
                                            onchange="add_dakshina_to_total()">
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="billing-details">
                        <table class="table table-bordered cart-total">
                            <tbody>
                                @php
                                $total_price = 0;
                                $pay_advance = 0;
                                $pay_advance_inclusion = 0;
                                @endphp
                                @foreach ($carts as $cart)
                                @php
                                $product_type = $cart->product->product_type;
                                @endphp
                                <tr>
                                    <td colspan="2">Package : {{ $cart->package?->package_name }}</td>
                                    {{-- <td class="product-name">Rs {{ $cart->package->discount_price }}</td> --}}
                                </tr>
                                @php
                                $pay_advance += (int) $cart->package?->advance;
                                $total_inclusion = 0;
                                $inclusions = json_decode($cart->inclusion);
                                @endphp
                                @if (is_array($inclusions) && count($inclusions) > 0)
                                @foreach ($inclusions as $inclusion)
                                @php
                                $inclusion_data = App\Models\Inclusion::find($inclusion);
                                if ($inclusion_data) {
                                $pay_advance_inclusion += $inclusion_data->advance;
                                $total_inclusion += (int) $inclusion_data->price;
                                }
                                @endphp
                                @if ($inclusion_data)
                                <tr>
                                    <td>{{ $inclusion_data->inclusion }}: <span>Included</span>
                                    </td>
                                    <td>Rs {{ $inclusion_data->price }}</td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="2">No inclusions available.</td>
                                </tr>
                                @endif

                                @php
                                $total = $cart->package?->discount_price + $total_inclusion;
                                $total_price += $total;
                                @endphp
                                @endforeach
                                <tr>
                                    <td>Sub Total</td>
                                    <td>Rs <span id="total">{{ $total_price }}</span></td>
                                </tr>
                                <tr>
                                    <td>Dakshina</td>
                                    <td>Rs <span id="dakshina_total">51</span></td>
                                </tr>
                            </tbody>
                        </table>
                        @php
                        $remaning_amount = $total_price - ($pay_advance + $pay_advance_inclusion);
                        @endphp
                        <div class="ordercalculation">
                            <div class="pay d-flex justify-content-between">
                                <div class="payfullamount">
                                    <input type="radio" name="deposite_radio" value="pay_full"
                                        onclick="toggleContent(this)" checked> <b>Pay Full Amount</b>
                                </div>
                                @if (session()->get('user_location') != 'online')
                                @if ($product_type != 'temple')
                                {{-- <div class="payadvance">
                                    <input type="radio" name="deposite_radio" value="pay_advance"
                                        onclick="toggleContent(this)">
                                    <b>Pay Advance</b> <span>Rs
                                        {{ $pay_advance + $pay_advance_inclusion }}</span>
                                </div> --}}
                                @endif
                                @endif

                            </div>
                            <div class="full" id="full">
                                <p class="total"><span class="advalet"> Total : </span> <strong> Rs <span
                                            id="total_amount">
                                            {{ $total_price }} </span></strong></p>
                            </div>
                            <div class="advance" id="advance">
                                <p><span class="advalet">Advance</span> : <strong><span>Rs
                                            {{ $pay_advance + $pay_advance_inclusion }}</span></strong></p>
                                <p><span class="advalet">Remaining</span> : <strong><span>Rs
                                            {{ $remaning_amount }}</span></strong></p>
                                <p class="total"><span>Total</span>: <strong><span>Rs {{ $total_price }}
                                        </span></strong></p>
                            </div>
                        </div>
                        <input type="hidden" id="order_id" name="order_id" />
                        <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" />
                        <a class="theme-btn btn-style-one" href="#" onclick="validateAndPay()">
                            <span class="btn-title">Place Order</span>
                        </a>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
</section>
@else
<section>
    <div class="auto-container">
        <div class="section-cart">
            <form id="order_form" name="order_form">
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <h3>पूजा में भाग लेने वाले सदस्यों के नाम</h3>
                        <div class="billing-details">
                            <div class="row">
                                @php $no_of_people=$carts[0]->package->no_of_people; @endphp
                                @for ($i = 1; $i <= $no_of_people; $i++) <div class="mb-2 col-md-6">
                                    <label for="checkuot-form-fname">पूरा नाम व्यक्ति
                                        {{ $i }}<span>*</span></label>
                                    <input type="text" name="name[]" id="name_{{ $i }}" class="form-control"
                                        placeholder="पूरा नाम" required>
                            </div>
                            @endfor
                            <div class="clearfix"></div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-lname">फोन नंबर <span>*</span></label>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="फोन नंबर"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10" required>
                            </div>

                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-email">वैकल्पिक संपर्क / व्हाट्सएप (वैकल्पिक)
                                </label>
                                <input type="number" name="alternate_contact" id="alternate_contact"
                                    class="form-control" placeholder="वैकल्पिक संपर्क / व्हाट्सएप (वैकल्पिक)"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card otp-box">
                                <div class="form-group floating-label">
                                    <div id="sms_otp" style="display:none;" class="otp_send">
                                        <div class="single-form mt-3">
                                            <p class="text-center">आपके फोन पर एक OTP भेजा गया है</p>
                                            <div id="divOuter" class="m-auto">
                                                <div id="divInner">
                                                    <input id="partitioned_sms" name="check_otp" type="text"
                                                        maxlength="4"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        onKeyPress="if(this.value.length==4) return false;" required>
                                                </div>
                                            </div>
                                            <p id="otp_error_sms" class="otp_send" style="text-align:center;"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="mb-10">संकल्प विवरण</h3>
                    <div class="billing-details">
                        <div class="row">
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">गोत्र (वैकल्पिक)</label>
                                <input type="text" name="gotra" id="gotra" class="form-control" placeholder="कश्यप">
                            </div>
                        </div>
                    </div>
                    @if ($carts[0]->product->prashad == 'yes')
                    <h3 class="mb-10 mt-3">प्रसाद विवरण</h3>
                    <div class="billing-details">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text">
                                <h4>क्या आप आशीर्वाद बॉक्स प्राप्त करना चाहेंगे?</h4>
                                <p>{{ $carts[0]->product->prashad_text_hindi }}</p>
                            </div>
                            <ul class="nav nav-pills custom-tab mb-3" id="pills-tab" role="tablist"
                                style="width:145px;">
                                <li class="nav-item" role="presentation">
                                    <input type="radio" class="nav-link" name="is_prasahd" id="pills-yes-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-yes" type="button" role="tab"
                                        aria-controls="pills-yes" aria-selected="false" onclick="add_required('yes')"
                                        value="yes" />
                                    हां
                                </li>
                                <li class="nav-item mx-1 mx-lg-4" role="presentation">
                                    <input type="radio" class="nav-link active" name="is_prasahd" id="pills-no-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-no" type="button" role="tab"
                                        aria-controls="pills-no" aria-selected="false" onclick="add_required('no')"
                                        value="no" checked /> नहीं
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade" id="pills-yes" role="tabpanel" aria-labelledby="pills-yes-tab">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <input type="number" name="pincode" id="pincode"
                                            class="form-control form-required" placeholder="पिन कोड (अनिवार्य)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="city" id="city" class="form-control form-required"
                                            placeholder="शहर का नाम (अनिवार्य)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="state" id="state" class="form-control form-required"
                                            placeholder="राज्य का नाम (अनिवार्य)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="house_no" id="house_no"
                                            class="form-control form-required"
                                            placeholder="घर का नंबर / बिल्डिंग नाम (अनिवार्य)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="area" id="area" class="form-control form-required"
                                            placeholder="सड़क नंबर / क्षेत्र / कॉलोनी (अनिवार्य)">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="landmark" id="landmark"
                                            class="form-control form-required" placeholder="लैंडमार्क (अनिवार्य)">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-no" role="tabpanel" aria-labelledby="pills-no-tab">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>पंडित को दक्षिणा</h4>
                            <div class="dakshina-tab">
                                <ul class="nav nav-pills custom-tab mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item me-3" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true" onclick="set_amount(51)">
                                            <i class="fas fa-rupee-sign"></i>
                                            51
                                        </button>
                                    </li>
                                    <li class="nav-item me-3" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false"
                                            onclick="set_amount(101)">
                                            <i class="fas fa-rupee-sign"></i>
                                            101
                                        </button>
                                    </li>
                                    <li class="nav-item me-3" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false"
                                            onclick="set_amount(201)">
                                            <i class="fas fa-rupee-sign"></i>
                                            201
                                        </button>
                                    </li>
                                </ul>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="number" name="dakshina" id="dakshina"
                                            class="form-control form-required" placeholder="" value="0" min="0"
                                            oninput="this.value = Math.abs(this.value)"
                                            onchange="add_dakshina_to_total()">
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="billing-details">
                        <table class="table table-bordered cart-total">
                            <tbody>
                                @php
                                $total_price = 0;
                                $pay_advance = 0;
                                $pay_advance_inclusion = 0;
                                @endphp
                                @foreach ($carts as $cart)
                                @php
                                $product_type = $cart->product->product_type;
                                @endphp
                                <tr>
                                    <td colspan="2">पैकेज : {{ $cart->package?->package_name_hindi }}
                                    </td>
                                    {{-- <td class="product-name">Rs {{ $cart->package->discount_price }}</td> --}}
                                </tr>
                                @php
                                $pay_advance += (int) $cart->package?->advance;
                                $total_inclusion = 0;
                                $inclusions = json_decode($cart->inclusion);
                                @endphp
                                @if (is_array($inclusions) && count($inclusions) > 0)
                                @foreach ($inclusions as $inclusion)
                                @php
                                $inclusion_data = App\Models\Inclusion::find($inclusion);
                                if ($inclusion_data) {
                                $pay_advance_inclusion += $inclusion_data->advance;
                                $total_inclusion += (int) $inclusion_data->price;
                                }
                                @endphp
                                @if ($inclusion_data)
                                <tr>
                                    <td>{{ $inclusion_data->inclusion_hindi }}:
                                        <span>समाविष्ट</span>
                                    </td>
                                    <td>Rs {{ $inclusion_data->price }}</td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="2">कोई समावेश उपलब्ध नहीं है।</td>
                                </tr>
                                @endif

                                @php
                                $total = $cart->package?->discount_price + $total_inclusion;
                                $total_price += $total;
                                @endphp
                                @endforeach
                                <tr>
                                    <td>कुल योग</td>
                                    <td>Rs <span id="total">{{ $total_price }}</span></td>
                                </tr>
                                <tr>
                                    <td>दक्षिणा</td>
                                    <td>Rs <span id="dakshina_total">51</span></td>
                                </tr>
                                <tr id="prashad_cost_row" style="display: none;">
                                    <td>प्रसाद लागत</td>
                                    <td>Rs <span id="prashad_total">{{ $carts[0]->product->prashad_price }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @php
                        $remaning_amount = $total_price - ($pay_advance + $pay_advance_inclusion);
                        @endphp
                        <div class="ordercalculation">
                            <div class="pay d-flex justify-content-between">
                                <div class="payfullamount">
                                    <input type="radio" name="deposite_radio" value="pay_full"
                                        onclick="toggleContent(this)" checked> <b>पूरा भुगतान करें</b>
                                </div>
                                @if (session()->get('user_location') != 'online')
                                @if ($product_type != 'temple')
                                @endif
                                @endif

                            </div>
                            <div class="full" id="full">
                                <p class="total"><span class="advalet"> कुल : </span> <strong> Rs <span
                                            id="total_amount">
                                            {{ $total_price }} </span></strong></p>
                            </div>
                            <div class="advance" id="advance">
                                <p><span class="advalet">एडवांस</span> : <strong><span>Rs
                                            {{ $pay_advance + $pay_advance_inclusion }}</span></strong></p>
                                <p><span class="advalet">बाकी</span> : <strong><span>Rs
                                            {{ $remaning_amount }}</span></strong></p>
                                <p class="total"><span>कुल</span>: <strong><span>Rs {{ $total_price }}
                                        </span></strong></p>
                            </div>
                        </div>
                        <input type="hidden" id="order_id" name="order_id" />
                        <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" />
                        <a class="theme-btn btn-style-one" href="#" onclick="validateAndPay()">
                            <span class="btn-title">आर्डर दें</span>
                        </a>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
</section>

@endif

<script>
    function toggleContent(radio) {
            // Hide all content by default
            document.getElementById("advance").style.display = "none";
            document.getElementById("full").style.display = "none";

            // Show content based on the selected radio button
            if (radio.value === "pay_advance") {
                document.getElementById("advance").style.display = "block";
            } else if (radio.value === "pay_full") {
                document.getElementById("full").style.display = "block";
            }
        }
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    function validateAndPay() {
            // Basic validation for required fields
            let isValid = true;
            let errorMessages = [];

            // Validate Name
            const name = $("#name_1").val();

            if (!name || name.length < 3) {
                isValid = false;
                alert("Full Name is required and must be at least 3 characters.");
                return;
            }

            // Validate Phone
            const phone = $("#phone").val();
            if (!/^\d{10}$/.test(phone)) {
                isValid = false;
                alert("Phone is required and must be 10 digits.");
                return;
            }

            // Validate Email

            const selectedValue = $('input[name="is_prasahd"]:checked').val();

            if (selectedValue == 'yes') {

                const pincode = $("#pincode").val();
                if (!/^\d+$/.test(pincode)) {
                    isValid = false;
                    alert("PinCode is required and must contain only numbers.");
                    return;
                }

                const city = $("#city").val();
                if (!city) {
                    isValid = false;
                    alert("City is required.");
                    return;
                }

                // Validate State
                const state = $("#state").val();
                if (!state) {
                    isValid = false;
                    alert("State is required.");
                    return;
                }

                const house_no = $("#house_no").val();
                if (!house_no) {
                    isValid = false;
                    alert("House No is required.");
                    return;
                }

                const area = $("#area").val();
                if (!area) {
                    isValid = false;
                    alert("Area is required .");
                    return;
                }


                const landmark = $("#landmark").val();
                if (!landmark) {
                    isValid = false;
                    alert("landmark is required .");
                    return;
                }
            }
            // Validate Address


            // Validate Country


            // Validate State


            // Validate City


            // Validate Zip Code




            // Proceed to Payment
            $('#order_form').submit();
        }

        // function add_dakshina_to_total() {
        //     var dakshina = parseInt($('#dakshina').val());
        //     if (dakshina) {
        //         if (dakshina<0){
        //             alert('Dakshina amount should not be negative.');
        //             $('#dakshina').val(0);
        //             return;
        //         }
        //         var total = parseInt($('#total').text());
        //         var new_dakshina = total + dakshina;
        //         $('#total_amount').text(new_dakshina);
        //         $('#dakshina_total').text(dakshina);
        //     } else {
        //         $('#dakshina').val(0);
        //         var dakshina = 0;
        //         var total = parseInt($('#total').text());
        //         var new_dakshina = total + dakshina;
        //         $('#total_amount').text(new_dakshina);
        //         $('#dakshina_total').text(dakshina);
        //     }

        // }


        function update_total_amount() {
            var dakshina = parseInt($('#dakshina').val()) || 0;
            var is_prashad_selected = $('input[name="is_prasahd"]:checked').val() === 'yes';
            var prashad_cost = $('input[name="is_prasahd"]:checked').val() === 'yes' ? parseInt(
                '{{ $carts[0]->product->prashad_price }}') || 0 : 0;
            var base_total = parseInt($('#total').text()) || 0;

            // Validation: Ensure Dakshina and Prashad cost are not negative
            if (dakshina < 0) {
                alert('Dakshina amount should not be negative.');
                $('#dakshina').val(0);
                dakshina = 0;
            }

            // Calculate new total
            var new_total = base_total + dakshina + prashad_cost;

            // Update the UI
            $('#total_amount').text(new_total);
            $('#dakshina_total').text(dakshina);
            $('#prashad_total').text(prashad_cost);

            if (is_prashad_selected) {
                $('#prashad_cost_row').show();
            } else {
                $('#prashad_cost_row').hide();
            }
        }

        // Call the function on input change
        $('#dakshina').on('input', update_total_amount);
        $('input[name="is_prasahd"]').on('change', update_total_amount);


        function pay() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            var formData = new FormData($('#order_form')[0]);
            $.ajax({
                type: 'POST',
                url: "{{ route('get_razorpay_order_id') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    $('#order_id').val(data.r_order_id);
                    console.log(data);

                    var r_order_id = data.r_order_id;

                    var options = {
                        "key": "{{ env('RAZORPAY_KEY') }}",
                        "currency": "INR",
                        "name": "Pujari Ji",
                        "description": "Payment",
                        "image": "{{ asset('public/logo.png') }}",
                        "order_id": r_order_id,
                        "handler": function(response) {
                            $('#razorpay_payment_id').val(response.razorpay_payment_id);
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });

                            var formData = new FormData($('#order_form')[0]);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('oneday_order.store') }}",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    console.log(response);
                                    window.location.replace(response.data);
                                }
                            });
                        },
                        "modal": {
                            "ondismiss": function() {

                                $('#loading_div').hide()
                            }
                        },
                        "prefill": {
                            "email": $('#email').val(),
                            "contact": $('#phone').val()
                        },
                        "theme": {
                            "color": "#624C25"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                }
            });

        }

        function set_amount(amount) {
            $('#dakshina').val(amount);
            update_total_amount();
        }

        $(document).ready(function() {
            update_total_amount();
        });

        function add_required(value) {
            if (value == 'yes') {
                $('.form-required').attr('required', 'required');

            } else {
                $('.form-required').removeAttr('required');
            }

            update_total_amount();
        }
</script>
<script>
    $.validator.addMethod("phoneIND", function(phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/[6789][0-9]{9}/);
        }, "Please specify a valid phone number");


        $("#phone").keyup(function() {
            $('#sms_otp').hide();
            $('#phone_check_error').html('');
            var phone = $('#phone').val();
            if (phone.length == 10) {

                $.ajax({
                    type: "POST",
                    async: true,
                    dataType: 'json',
                    url: "{{ route('send_regsiter_otp') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        phone: phone,
                        form_name: 'sms_form'
                    },
                    success: function(response) {

                        if (response.status == true) {
                            $('#phone_check_error').html('');
                            $('#sms_form_div').hide();
                            $('#sms_form_button_div').hide();
                            $('#login_by_sms').hide();
                            $('#sms_otp').show();
                            $('#sms_otp_number').text(phone);
                            var otp = response.otp;
                            $.validator.addMethod(
                                'otpcheck',
                                function(value, element) {
                                    return value == otp;
                                },
                                'Invalid OTP.'
                            );
                        }

                    }
                });
            }

        });


        $("#partitioned_sms").keyup(function() {
            var check_otp = $('#partitioned_sms').val();
            $('#otp_error_sms').html('');
            if (check_otp.length == 4) {
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: 'json',
                    url: "{{ route('check_otp') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        otp: check_otp
                    },
                    success: function(response) {
                        console.log(response);

                        if (response.status == true) {
                            $('#otp_error_sms').html('OTP Verified !');
                            $('#otp_error_sms').addClass('correct');
                            return true;
                        }
                        if (response.status == false) {
                            $('#otp_error_sms').html('');
                            return false;
                        }

                    }
                });
            }
        });
</script>
<script>
    $(function() {

            $("form[name='order_form']").validate({
                rules: {

                    check_otp: {
                        required: true,
                        otpcheck: true
                    },
                },
                messages: {
                    check_otp: {
                        required: "Please Enter OTP!",
                        otpcheck: "Invalid OTP!"
                    },
                },

                submitHandler: function(form) {
                    pay();
                }
            });
        });
</script>
@endsection