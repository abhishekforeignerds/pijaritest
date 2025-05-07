@extends('frontend.layouts.app')
@section('content')
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
        color: red !important;
    }

    .correct {
        color: green;
    }

    .error {
        color: red !important;
    }
</style>
<div class="auto-container">
    <div class="section-cart">
        <form name="order_form" id="order_form" action="#" method="POST">
            @csrf
            @if(session()->get('pooja_language')=='English')
            <div class="row">
                <div class="col-md-7">
                    <h3 class="mb-10">Sankalp Details</h3>
                    <div class="billing-details">
                        <div class="row">
                            <div class="mb-2 col-md-6">
                                <label for="name">Full Name <span>*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Full Name"
                                    value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                            </div>

                            @if (session()->get('user_location') == 'online')
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">Rashi Name (optional)</label>
                                <input type="text" name="rashi_name" id="rashi_name" class="form-control"
                                    placeholder="Enter Your Rashi Name">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">DOB (optional)</label>
                                <input type="date" name="dob" name="dob" id="dob" class="form-control"
                                    placeholder="Enter Your DOB">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">Gotra (optional)</label>
                                <input type="text" name="gotra" id="gotra" class="form-control" placeholder="Kashyap">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">Community (optional)</label>
                                <input type="text" name="varn" id="varn" class="form-control"
                                    placeholder="Enter Your Community">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">Wife Name (optional)</label>
                                <input type="text" name="wife_name" id="wife_name" class="form-control"
                                    placeholder="Enter Your Wife Name">
                            </div>
                            @endif
                        </div>
                    </div>
                    <h3 class="mb-10 mt-3">Billing Details</h3>
                    <div class="billing-details">
                        <div class="row">

                            <div class="mb-2 col-md-6">
                                <label for="phone">Phone <span>*</span></label>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone"
                                    value="{{ auth()->check() ? auth()->user()->phone : '' }}" {{ auth()->check() ?
                                'readonly' : '' }}
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                onKeyPress="if(this.value.length==10) return false;" maxlength="10" required>
                            </div>


                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-email">Whatsapp (optional) </label>
                                <input type="number" name="alternate_contact" id="alternate_contact"
                                    class="form-control" placeholder="Whatsapp (optional)"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10">
                            </div>

                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">Email address <span></span></label>
                                <input type="email" name="email" id="email"
                                    value="{{ auth()->check() ? auth()->user()->email : '' }}" class="form-control"
                                    placeholder="Email Address">
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
                                                                onKeyPress="if(this.value.length==4) return false;"
                                                                required>
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
                            <div class="col-md-12">
                                @if(session()->get('user_location') == 'online')
                                <div class="mb-2">
                                    <label for="checkuot-form-address">Address </label>
                                    <input name="address" type="text" id="address" class="form-control"
                                        placeholder="Street address">
                                </div>
                                @else
                                <div class="mb-2">
                                    <label for="checkuot-form-address">Address <span>*</span> </label>
                                    <input name="address" type="text" id="address" class="form-control"
                                        placeholder="Street address" required>
                                </div>
                                @endif

                            </div>
                            @if(session()->get('user_location') == 'online')
                            <div class="mb-2 col-md-6">
                                <label>Country <span></span></label>
                                <select class="form-control" name="country" id="country">
                                    <option>Select Country</option>
                                    <option>India</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label>State/Province <span></span></label>
                                <input name="state" type="text" id="state" class="form-control" placeholder="State">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-city">City <span></span></label>
                                <input name="city" type="text" id="city" class="form-control" placeholder="City">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-zip">Zip/Postal Code <span></span></label>
                                <input type="text" name="zip_code" id="zip_code" class="form-control"
                                    placeholder="Zip/Postal Code">
                            </div>
                            @else
                            <div class="mb-2 col-md-6">
                                <label>Country <span>*</span></label>
                                <select class="form-control" name="country" id="country" required>
                                    <option>Select Country</option>
                                    <option>India</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label>State/Province <span>*</span></label>
                                <input name="state" type="text" id="state" class="form-control" placeholder="State"
                                    required>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-city">City <span>*</span></label>
                                <input name="city" type="text" id="city" class="form-control" placeholder="City"
                                    required>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-zip">Zip/Postal Code <span>*</span></label>
                                <input type="text" name="zip_code" id="zip_code" class="form-control"
                                    placeholder="Zip/Postal Code" required>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h3 class="mb-10" style="color:#c64d04">{{ appSetupValue('sankalp_message') }}</h3>
                    <div class="billing-details">
                        {{-- <h4 class="pb-10 mt-10">Cart Totals</h4> --}}
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
                                    <td>Pooja</td>
                                    <td class="product-name"><a href="#">{{ $cart->product->name }}</a>
                                        <ul class="variation">
                                            <li class="variation-size">City: <span>{{ $cart->city }}</span>
                                            </li>
                                            <li class="variation-size">Pooja Type:
                                                <span>{{ $cart->location }}</span>
                                            </li>
                                            <li class="variation-size">Packages:
                                                <span>{{ $cart->package?->package_name }}</span>
                                            </li>
                                            @php
                                            $pay_advance =
                                            (int) $pay_advance + (int) $cart->package?->advance;
                                            $total_inclusion = 0;
                                            $inclusions = json_decode($cart->inclusion);
                                            @endphp

                                            @if (is_array($inclusions) && count($inclusions) > 0)
                                            @foreach ($inclusions as $inclusion)
                                            @php
                                            $inclusion_data = App\Models\Inclusion::find(
                                            $inclusion,
                                            );
                                            $pay_advance_inclusion =
                                            $pay_advance_inclusion +
                                            $inclusion_data->advance;
                                            @endphp
                                            @if ($inclusion_data)
                                            <li class="variation-size">
                                                {{ $inclusion_data->inclusion }}:
                                                <span>Included</span>
                                            </li>
                                            @php
                                            $total_inclusion +=
                                            (int) $inclusion_data->price;
                                            @endphp
                                            @endif
                                            @endforeach
                                            @else
                                            <li>No inclusions available.</li>
                                            @endif

                                            @php
                                            $total = $cart->package?->discount_price + $total_inclusion;
                                            $total_price += $total;
                                            @endphp
                                            @if ($product_type != 'temple')
                                            <li class="variation-size">Priest Preference:
                                                <span>{{ $cart->language }}</span>
                                            </li>
                                            @endif
                                            <li class="variation-size">Date & Time: <span>{{ $cart->date }} &
                                                    {{ $cart->time }}</span></li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>Total</td>
                                    <td>Rs {{ $total_price }}</td>
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
                                <div class="payadvance">
                                    <input type="radio" name="deposite_radio" value="pay_advance"
                                        onclick="toggleContent(this)">
                                    <b>Pay Advance</b> <span>Rs
                                        {{ $pay_advance + $pay_advance_inclusion }}</span>
                                </div>
                                @endif
                                @endif

                            </div>
                            <div class="full" id="full">
                                <p class="total"><span class="advalet">Total</span>: <strong><span>Rs
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

                        <a class="theme-btn btn-style-one" href="#" onclick="validateAndPay()"><span
                                class="btn-title">Place Order</span> </a>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-7">
                    <h3 class="mb-10">संकल्प विवरण</h3>
                    <div class="billing-details">
                        <div class="row">
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-fname">पूरा नाम <span>*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="पूरा नाम"
                                    required>
                            </div>
                            @if (session()->get('user_location') == 'online')
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">राशि नाम (वैकल्पिक)</label>
                                <input type="text" name="rashi_name" id="rashi_name" class="form-control"
                                    placeholder="अपना राशि नाम दर्ज करें">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">जन्म तिथि (वैकल्पिक)</label>
                                <input type="date" name="dob" id="dob" class="form-control"
                                    placeholder="अपनी जन्म तिथि दर्ज करें">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">गोत्र (वैकल्पिक)</label>
                                <input type="text" name="gotra" id="gotra" class="form-control" placeholder="कश्यप">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">समुदाय (वैकल्पिक)</label>
                                <input type="text" name="varn" id="varn" class="form-control"
                                    placeholder="अपना समुदाय दर्ज करें">
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">पत्नी का नाम (वैकल्पिक)</label>
                                <input type="text" name="wife_name" id="wife_name" class="form-control"
                                    placeholder="अपनी पत्नी का नाम दर्ज करें">
                            </div>
                            @endif
                        </div>
                    </div>
                    <h3 class="mb-10 mt-3">बिलिंग विवरण</h3>
                    <div class="billing-details">
                        <div class="row">
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-lname">फ़ोन <span>*</span></label>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="फ़ोन"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10" required>
                            </div>

                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-email">वैकल्पिक संपर्क / व्हाट्सएप (वैकल्पिक)</label>
                                <input type="number" name="alternate_contact" id="alternate_contact"
                                    class="form-control" placeholder="वैकल्पिक संपर्क / व्हाट्सएप (वैकल्पिक)"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10">
                            </div>

                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-cname">ईमेल पता <span></span></label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="ईमेल पता">
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
                                                                onKeyPress="if(this.value.length==4) return false;"
                                                                required>
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

                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="checkuot-form-address">पता <span>*</span></label>
                                    <input name="address" type="text" id="address" class="form-control"
                                        placeholder="सड़क का पता" required>
                                </div>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label>देश <span>*</span></label>
                                <select class="form-control" name="country" id="country" required>
                                    <option>देश चुनें</option>
                                    <option>भारत</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label>राज्य/प्रांत <span>*</span></label>
                                <input name="state" type="text" id="state" class="form-control" placeholder="राज्य"
                                    required>
                            </div>
                            <div class="mb-2 col-md-6">

                                <label for="checkuot-form-city">शहर <span>*</span></label>
                                <input name="city" type="text" id="city" class="form-control" placeholder="शहर"
                                    required>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="checkuot-form-zip">ज़िप/पोस्टल कोड <span>*</span></label>
                                <input type="text" name="zip_code" id="zip_code" class="form-control"
                                    placeholder="ज़िप/पोस्टल कोड" required>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h3 class="mb-10" style="color:#c64d04">{{ appSetupValue('sankalp_message') }}</h3>
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
                                    <td>पूजा</td>
                                    <td class="product-name"><a href="#">पूजा का नाम : {{ $cart->product->name_hindi
                                            }}</a>
                                        <ul class="variation">
                                            @php
                                            $city_name=App\Models\ServiceCity::where('city',session()->get('city'))->first();
                                            @endphp
                                            <li class="variation-size">शहर:
                                                <span>@if(!empty($city_name->city_name_hindi))
                                                    {{$city_name->city_name_hindi}} @else {{session()->get('city')}}
                                                    @endif</span>
                                            </li>
                                            <li class="variation-size">पूजा स्थान: <span>@if ($cart->location ==
                                                    'online') ऑनलाइन @endif @if ($cart->location == 'home') मेरे घर पर
                                                    @endif</span></li>
                                            <li class="variation-size">पैकेज: <span>{{
                                                    $cart->package?->package_name_hindi }}</span></li>
                                            @php
                                            $pay_advance = (int) $pay_advance + (int) $cart->package?->advance;
                                            $total_inclusion = 0;
                                            $inclusions = json_decode($cart->inclusion);
                                            @endphp

                                            @if (is_array($inclusions) && count($inclusions) > 0)
                                            @foreach ($inclusions as $inclusion)
                                            @php
                                            $inclusion_data = App\Models\Inclusion::find($inclusion);
                                            $pay_advance_inclusion = $pay_advance_inclusion + $inclusion_data->advance;
                                            @endphp
                                            @if ($inclusion_data)
                                            <li class="variation-size">
                                                समावेश : <span>{{ $inclusion_data->inclusion_hindi }}</span>
                                            </li>
                                            @php
                                            $total_inclusion += (int) $inclusion_data->price;
                                            @endphp
                                            @endif
                                            @endforeach
                                            @else
                                            <li>कोई समावेश उपलब्ध नहीं है।</li>
                                            @endif

                                            @php
                                            $total = $cart->package?->discount_price + $total_inclusion;
                                            $total_price += $total;
                                            @endphp
                                            @if ($product_type != 'temple')
                                            <li class="variation-size">पुजारी भाषा: <span>{{ $cart->language }}</span>
                                            </li>
                                            @endif
                                            <li class="variation-size">तारीख और समय: <span>{{ $cart->date }} & {{
                                                    $cart->time }}</span></li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>कुल</td>
                                    <td>Rs {{ $total_price }}</td>
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
                                        onclick="toggleContent(this)" checked> <b>पूर्ण राशि का भुगतान करें</b>
                                </div>
                                @if (session()->get('user_location') != 'online')
                                @if ($product_type != 'temple')
                                <div class="payadvance">
                                    <input type="radio" name="deposite_radio" value="pay_advance"
                                        onclick="toggleContent(this)">
                                    <b>अग्रिम भुगतान करें</b> <span>Rs {{ $pay_advance + $pay_advance_inclusion
                                        }}</span>
                                </div>
                                @endif
                                @endif
                            </div>
                            <div class="full" id="full">
                                <p class="total"><span class="advalet">कुल</span>: <strong><span>Rs {{ $total_price }}
                                        </span></strong></p>
                            </div>
                            <div class="advance" id="advance">
                                <p><span class="advalet">अग्रिम</span> : <strong><span>Rs {{ $pay_advance +
                                            $pay_advance_inclusion }}</span></strong></p>
                                <p><span class="advalet">बकाया</span> : <strong><span>Rs {{ $remaning_amount
                                            }}</span></strong></p>
                                <p class="total"><span>कुल</span>: <strong><span>Rs {{ $total_price }}</span></strong>
                                </p>
                            </div>
                        </div>

                        <input type="hidden" id="order_id" name="order_id" />
                        <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" />

                        <a class="theme-btn btn-style-one" href="#" onclick="validateAndPay()"><span
                                class="btn-title">ऑर्डर प्लेस करें</span> </a>
                    </div>
                </div>
            </div>

            @endif
        </form>
        @guest
        <button type="button" id="sendotp" class="btn btn-sm btn-success my-4">Send OTP <i
                class="fad fa-angle-right"></i></button>

        <span id="resendTimer" style="margin-left:.5rem;"></span>
        <style>
            button#sendotp,
            #resendTimer {
                position: relative;
                bottom: 32rem;
                left: 15rem;
            }

            #sendotp.resend-position,
            #resendTimer {
                bottom: 39rem;
                left: 10rem;
            }
        </style>
        <form action="{{ route('customer.login') }}" method="POST" id="sms_form_modal">
            @csrf
            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
            <div class="form-group">
                {{-- <label for="customer_name">Name</label> --}}
                <input type="hidden" class="form-control" id="customer_name" name="name" required>
            </div>
            <div class="form-group" id="sms_form_div">
                {{-- <label for="sms_number">Mobile Number</label> --}}
                <input type="hidden" class="form-control" name="input_name" id="sms_number"
                    placeholder="10‑digit mobile" maxlength="10" required>
                <span id="phone_check_error" class="text-danger"></span>
            </div>
            <div id="sms_otp" style="display:none;">
                <p>An OTP has been sent to <strong><span id="sms_otp_number"></span></strong>
                    <a href="#" onclick="sms_edit_number()">(Edit)</a>
                </p>
                <div class="form-group">
                    <input id="partitioned_sms" name="check_otp" class="form-control" maxlength="4"
                        placeholder="Enter OTP" required>
                    <span id="otp_error_sms" class="text-danger"></span>
                </div>
            </div>
            <div class="text-center" hidden>
                <button type="button" id="login_by_sms" class="btn btn-theme">Login with SMS OTP <i
                        class="fad fa-angle-right"></i></button>
                <button type="submit" class="btn btn-primary" style="display:none;" id="submit_login">Submit</button>
            </div>
        </form>
        @endguest
    </div>
</div>
<script>
    const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
        const confirmPassword = document.querySelector("#confirmPassword");

        // Toggle Password Visibility
        togglePassword.addEventListener("click", function() {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            const icon = this.querySelector('i');
            if (type === "password") {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        // Toggle Confirm Password Visibility
        toggleConfirmPassword.addEventListener("click", function() {
            const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
            confirmPassword.setAttribute("type", type);

            const icon = this.querySelector('i');
            if (type === "password") {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
</script>
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
            const name = $("#name").val();

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
            // const email = $("#email").val();
            // if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            //     isValid = false;
            //     alert("A valid email address is required.");
            //     return;
            // }

            // Validate Address
            const address = $("#address").val();
            if (!address) {
                isValid = false;
                alert("Address is required.");
                return;
            }

            // Validate Country
            const country = $("#country").val();
            if (!country) {
                isValid = false;
                alert("Country is required.");
                return;
            }

            // Validate State
            const state = $("#state").val();
            if (!state) {
                isValid = false;
                alert("State is required.");
                return;
            }

            // Validate City
            const city = $("#city").val();
            if (!city) {
                isValid = false;
                alert("City is required.");
                return;
            }

            // Validate Zip Code
            const zipCode = $("#zip_code").val();
            if (!/^\d+$/.test(zipCode)) {
                isValid = false;
                alert("Zip Code is required and must contain only numbers.");
                return;
            }



            // Proceed to Payment
            $('#order_form').submit();
        }

        function pay() {
            $('.theme-btn').prop('disabled', true);
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
                                url: "{{ route('order.store') }}",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    window.location.replace(response.data);
                                }
                            });
                        },
                        "modal": {
                            "ondismiss": function() {
                                $('.theme-btn').prop('disabled', false);
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

</script>

<script>
    $.validator.addMethod("phoneIND", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
            phone_number.match(/[6789][0-9]{9}/);
    }, "Please specify a valid phone number");


    // $("#phone").keyup(function() {
    //     $('#sms_otp').hide();
    //     $('#phone_check_error').html('');
    //     var phone = $('#phone').val();
    //     if (phone.length == 10) {

    //         $.ajax({
    //             type: "POST",
    //             async: true,
    //             dataType: 'json',
    //             url: "{{ route('send_regsiter_otp') }}",
    //             data: {
    //                 _token: '{{ csrf_token() }}',
    //                 phone: phone,
    //                 form_name: 'sms_form'
    //             },
    //             success: function(response) {

    //                 if (response.status == true) {
    //                     $('#phone_check_error').html('');
    //                     $('#sms_form_div').hide();
    //                     $('#sms_form_button_div').hide();
    //                     $('#login_by_sms').hide();
    //                     $('#sms_otp').show();
    //                     $('#sms_otp_number').text(phone);
    //                     var otp = response.otp;
    //                     $.validator.addMethod(
    //                         'otpcheck',
    //                         function(value, element) {
    //                             return value == otp;
    //                         },
    //                         'Invalid OTP.'
    //                     );
    //                 }

    //             }
    //         });
    //     }

    // });

    $("#sendotp").click(function() {
    var phone      = $('#phone').val();
    var full_name  = $('#name').val();

    if (phone.length === 10 && full_name.length > 3) {
      var $btn = $(this);

      // 1) change text to “Resend OTP”
      $btn.text('Resend OTP');

      // 2) add class to position it at top:38rem
      $btn.addClass('resend-position');

      // 3) disable it while countdown runs
      $btn.prop('disabled', true);

      // 4) start a 2‑minute (120s) countdown
      startResendTimer(120, $('#resendTimer'), $btn);
    console.log("[OTP DEBUG] phone length is 10, sending AJAX to send_register_otp");
    $('#sms_otp').show();
    $('#phone_check_error').html('');
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "{{ route('send_regsiter_otp') }}",
      data: {
        _token: '{{ csrf_token() }}',
        phone: phone,
        form_name: 'sms_form'
      },
      beforeSend: function() {
        console.log("[OTP DEBUG] AJAX request about to be sent with data:", {
          phone: phone,
          form_name: 'sms_form'
        });
      },
      success: function(response) {
        console.log("[OTP DEBUG] AJAX success response:", response);
        if (response.status === true) {
          console.log("[OTP DEBUG] Status true, OTP received:", response.otp);
          // Show the OTP input
          $('#sms_otp').show();
          // Store the returned OTP in JS for client-side validation
          var otp = response.otp;
          $.validator.addMethod('otpcheck', function(value, element) {
            console.log("[OTP DEBUG] validating entered OTP:", value, "against", otp);
            return value == otp;
          }, 'Invalid OTP.');
        } else {
          console.warn("[OTP DEBUG] send_register_otp returned status false");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("[OTP DEBUG] AJAX error:", textStatus, errorThrown);
      }
    });
  } else {
    alert('Enter Phone name and Full Name (must be greater than 3 Characters)')
  }
});
function startResendTimer(duration, $display, $button) {
    var timer = duration, minutes, seconds;
    var interval = setInterval(function() {
      minutes = Math.floor(timer / 60);
      seconds = timer % 60;
      $display.text(
        (minutes < 10 ? '0' + minutes : minutes)
        + ':' +
        (seconds < 10 ? '0' + seconds : seconds)
      );

      if (--timer < 0) {
        clearInterval(interval);
        // re‑enable button & clear timer display
        $button.prop('disabled', false);
        $display.text('');
      }
    }, 1000);
  }
    $("#partitioned_sms").keyup(function() {
        var check_otp = $('#partitioned_sms').val();
        var phone = $('#phone').val();
        var full_name = $('#name').val();
        const form = document.getElementById('sms_form_modal');
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
                        document.getElementById('sms_number').value = phone;
                        document.getElementById('customer_name').value = full_name;
                        form.submit();
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