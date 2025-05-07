@extends('frontend.layouts.app')
@section('content')
<style>
    .date-selected {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>
@if ($errors->any())
<h4 style="color:red;">{{ $errors->first() }}</h4>
@endif
@php
$user_id = 0;
$check_user = Auth::check();

if ($check_user) {
$user_id = Auth::user()->id;
} else {
$check_session = Session::get('guest_id');
if ($check_session) {
$user_id = $check_session;
}
}

@endphp

@if ($product->product_type == 'all')
<section class="page-title">
    <div class="auto-container">
        <div class="row">

            <!-- Left Section -->
            <div class="col-12 col-lg-8 mb-3">
                <form action="{{ route('listing') }}" method="GET" enctype="multipart/form-data">
                    @if (session()->get('pooja_language') == 'English')
                    <div class="checkout-form">

                    </div>
                    @else
                    <div class="checkout-form">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="select-city mb-3 me-2 flex-grow-1">
                                <select id="city" name="city" class="select-input-form js-example-basic-single w-100"
                                    data-live-search="true" onchange="set_city()">
                                    <option value="">शहर चुनें</option>
                                    @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                    <option value="{{ $city->city }}" @if (session()->get('city') == $city->city)
                                        selected @endif>
                                        {{ $city->city }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="select-language mb-3 me-lg-2 me-0 flex-grow-1">
                                <select id="language" name="language"
                                    class="select-input-form js-example-basic-single w-100" onchange="set_language()">
                                    <option value="">भाषा चुनें</option>
                                    @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                    <option value="{{ $language->language }}" @if (session()->get('language') ==
                                        $language->language) selected @endif>
                                        {{ $language->language }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="view-button">
                                <button class="theme-btn btn-style-one pack-btn" type="submit">
                                    <span class="btn-title">सभी सेवाएं देखें</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            <!-- Right Section -->
            @if (session()->get('pooja_language') == 'English')
            <div class="col-lg-4 col-12">
                <div class="sidebar-search">
                    <form action="{{ route('listing') }}" method="GET" class="search-form">
                        <div class="form-group d-flex">
                            <input type="search" name="search" placeholder="Search..." value="{{ request('search') }}"
                                required="">
                            <button><i class="lnr lnr-icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="col-lg-4 col-12">
                <div class="sidebar-search">
                    <form action="{{ route('listing') }}" method="GET" class="search-form">
                        <div class="form-group d-flex">
                            <input type="search" name="search" placeholder="खोजें..." value="{{ request('search') }}"
                                required="">
                            <button><i class="lnr lnr-icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        @if (session()->get('pooja_language') == 'English')
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('puja') }}">Puja</a></li>
            <li class="breadcrumb-item"><a href="{{ route('details', $product->slug) }}">{{ $product->name }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('product_package', $product->slug) }}"> Package</a>
            </li>
            <li class="breadcrumb-item"> Check Availability </li>
            <li class="ms-auto">
                <a href="{{ route('product_package', $product->slug) }}" class="btn btn-success">
                    <span class="btn-title text-white"><i class="fa fa-arrow-left"></i> Back</span>
                </a>
            </li>
        </ul>
        @else
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">होम</a></li>
            <li class="breadcrumb-item"><a href="{{ route('puja') }}">पूजा</a></li>
            <li class="breadcrumb-item"><a href="{{ route('details', $product->slug) }}">{{ $product->name_hindi }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('product_package', $product->slug) }}">पैकेज</a></li>
            <li class="breadcrumb-item">उपलब्धता जांचें</li>
            <li class="ms-auto">
                <a href="{{ route('product_package', $product->slug) }}" class="btn btn-success">
                    <span class="btn-title text-white"><i class="fa fa-arrow-left"></i> वापस</span>
                </a>
            </li>
        </ul>
        @endif
    </div>
</div>
@endif
@if ($product->product_type == 'temple')
<div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        @if (session()->get('pooja_language') == 'English')
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teerth_puja') }}">Teerth Puja</a></li>
            <li class="breadcrumb-item"><a href="{{ route('details', $product->slug) }}">{{ $product->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product_package', $product->slug) }}"> Package</a>
            </li>
            <li class="breadcrumb-item"> Check Availability </li>

            <li class="ms-auto">
                <a href="{{ route('product_package', $product->slug) }}" class="btn btn-success">
                    <span class="btn-title text-white"><i class="fa fa-arrow-left"></i> Back</span>
                </a>
            </li>
        </ul>
        @else
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">होम</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teerth_puja') }}">तीर्थ पूजा</a></li>
            <li class="breadcrumb-item"><a href="{{ route('details', $product->slug) }}">{{ $product->name_hindi }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('product_package', $product->slug) }}">पैकेज</a>
            </li>
            <li class="breadcrumb-item">उपलब्धता जांचें</li>

            <li class="ms-auto">
                <a href="{{ route('product_package', $product->slug) }}" class="btn btn-success">
                    <span class="btn-title text-white"><i class="fa fa-arrow-left"></i> वापस</span>
                </a>
            </li>
        </ul>
        @endif
    </div>
</div>
@endif
<section class="package-details">
    <div class="auto-container">
        <form action="{{ route('availability', $product->slug) }}" method="GET" enctype="multipart/form-data">
            <div class="row">

                @if (session()->get('pooja_language') == 'English')
                <div class="col-lg-8 col-xl-8">
                    <div class="col-12">

                        <div class="d-flex align-items-center justify-content-between border-top border-bottom py-2">
                            <div class="d-flex flex-column-reverse align-items-start">
                                <img class="img-fluid" src="{{ $product->full_image_url }}" alt=""
                                    style="max-height: 100px; width: auto;">


                            </div>
                            <div class="d-flex flex-column-reverse align-items-start">
                                <span>{{ $package->package_name }}</span>

                            </div>
                            <div class="d-flex flex-column-reverse align-items-start">
                                <span class="text-success">Total : ₹{{ $package->discount_price }}</span>

                            </div>


                        </div>
                    </div>
                    <div class="col-12 border-right mb-5">
                        <h5>Inclusions</h5>
                        <ul class="inclusions">
                            @foreach(
                            $inclusions
                            as $inclusion
                            )
                            @if ($inclusion->price < 1) <li>
                                <div class="d-flex align-items-center justify-content-between border-bottom">

                                    <span>{{ $inclusion->inclusion }}</span>
                                    <span id="toggle-btn_9_27" class="mx-3 my-3"
                                        onclick="toggleInclusion('4','9','27', this)">
                                        Included
                                    </span>
                                </div>
                                </li>
                                @else
                                @php
                                $isSelected = in_array($inclusion->id, $selectedInclusions);
                                @endphp
                                <li>
                                    <input type="checkbox" id="inclusion-checkbox_{{ $packageid }}_{{ $inclusion->id }}"
                                        class="inclusion-checkbox_{{ $packageid }}" value="{{ $inclusion->id }}"
                                        style="display: none;" {{ $isSelected ? 'checked' : '' }} />

                                    <div class="d-flex align-items-center justify-content-between border-bottom py-2">
                                        <div class="d-flex flex-column-reverse align-items-start">
                                            <span class="text-success">₹{{ $inclusion->price }}</span>
                                            <span>{{ $inclusion->inclusion }}</span>
                                        </div>

                                        <button type="button" id="toggle-btn_{{ $packageid }}_{{ $inclusion->id }}"
                                            class="btn btn-sm mx-2 {{ $isSelected ? 'btn-danger' : 'btn-success' }} toggle-inclusion-btn"
                                            onclick="toggleInclusion('{{ $product->id }}','{{ $packageid }}','{{ $inclusion->id }}', this)">
                                            {{ $isSelected ? '- Remove' : '+ Add' }}
                                        </button>
                                    </div>
                                </li>

                                <script>
                                    function toggleInclusion(productId, packageId, inclusionId, btn) {
                                            const cb = document.getElementById(`inclusion-checkbox_${packageId}_${inclusionId}`);
                        
                                            // toggle checked state
                                            cb.checked = !cb.checked;
                        
                                            // update button label & classes
                                            if (cb.checked) {
                                                btn.textContent = ' - Remove';
                                                btn.classList.remove('btn-success');
                                                btn.classList.add('btn-danger');
                                            } else {
                                                btn.textContent = ' + Add';
                                                btn.classList.remove('btn-danger');
                                                btn.classList.add('btn-success');
                                            }
                        
                                            // preserve original add_to_cart behavior
                                            add_to_cart(productId, packageId);
                                        }
                                </script>
                                @endif
                                @endforeach

                        </ul>

                    </div>
                    <div class="product-info">

                        <div class="pooja-at form-fixed">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Pooja Performed in : {{ session()->get('city') }}</b>
                                </div>
                                <div class="col-md-6"></div>

                                @if ($product->product_type == 'all')
                                <div class="col-md-4 col-4 mb-4">
                                    <select id="location" name="location" class="select-input-form w-100"
                                        style="border: 1px solid #dddddd;"
                                        onchange="set_location('{{ $product->id }}')">
                                        <option value="">Select Location</option>
                                        @if ($product->location_type == 'both')
                                        <option value="home" @if (session()->get('user_location') == 'home') selected
                                            @endif>At
                                            My Home</option>
                                        <option value="online" @if (session()->get('user_location') == 'online')
                                            selected
                                            @endif>Online</option>
                                        @elseif ($product->location_type == 'offline')
                                        <option value="home" @if (session()->get('user_location') == 'home') selected
                                            @endif>At
                                            My Home</option>
                                        @else
                                        <option value="online" @if (session()->get('user_location') == 'online')
                                            selected
                                            @endif>Online</option>
                                        @endif
                                    </select>
                                </div>

                                @if (session()->get('user_location') != 'online')
                                <div class="col-md-4 col-4 mb-4">
                                    <select id="city" name="city"
                                        class="select-input-form js-example-basic-single w-100" data-live-search="true"
                                        onchange="set_city_detail()">
                                        <option value="">Select City</option>
                                        @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                        <option value="{{ $city->city }}" @if (session()->get('city') == $city->city)
                                            selected
                                            @endif>
                                            {{ $city->city }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-md-4 col-4 mb-4">
                                    <select id="language" name="language"
                                        class="select-input-form js-example-basic-single w-100"
                                        onchange="set_language_detail()">
                                        <option value="">Select Language</option>
                                        @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                        <option value="{{ $language->language }}" @if (session()->get('language') ==
                                            $language->language) selected @endif>
                                            {{ $language->language }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @elseif ($product->product_type == 'temple')
                                <div class="col-md-4 col-12 mb-4">
                                    <select id="location" name="location" class="select-input-form w-100"
                                        style="border: 1px solid #dddddd;"
                                        onchange="set_location('{{ $product->id }}')">
                                        <option value="">Select Location</option>
                                        @if ($product->location_type == 'both')
                                        <option value="at_location" @if (session()->get('user_location') ==
                                            'at_location')
                                            selected @endif>At Location</option>
                                        <option value="online" @if (session()->get('user_location') == 'online')
                                            selected
                                            @endif>Online</option>
                                        @elseif ($product->location_type == 'offline')
                                        <option value="at_location" @if (session()->get('user_location') ==
                                            'at_location')
                                            selected @endif>At Location</option>
                                        @else
                                        <option value="online" @if (session()->get('user_location') == 'online')
                                            selected
                                            @endif>Online</option>
                                        @endif
                                    </select>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="product-details__top">
                            <h3 class="product-details__title">Date & Time Requirements</h3>
                        </div>
                        <div class="product-details__content">
                            <div class="your-package date-availability">
                                <div class="row align-items-center">
                                    <div class="col-md-6 mb-3">
                                        <label for="pooja-date">Select Date for Pooja</label>
                                        <div class="availability">
                                            <input type="date" min="{{ date('Y-m-d') }}" name="date_availability"
                                                class="" id="datePicker" placeholder="Select Date for Pooja"
                                                value="{{ request('date_availability') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="time">Time Preference (optional)</label>
                                        <div class="availability">
                                            <input type="time" name="time" class=""
                                                placeholder="Time Preference (optional)" value="{{ request('time') }}">
                                        </div>
                                    </div>
                                    @if ($is_available != 'yes')
                                    <div class="col-lg-12 col-12 px-0 text-end">
                                        <div class="form-submit mt-20">
                                            <button type="submit" class="theme-btn btn-style-one" id="selectButton"
                                                disabled>Check Availability</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-lg-8 col-xl-8">
                    <div class="product-info">
                        <div class="product-details__top">
                            <h3 class="product-details__title">तारीख और समय की आवश्यकताएँ</h3>
                        </div>
                        <div class="product-details__content">
                            <div class="your-package date-availability">
                                <div class="row align-items-center">

                                    <div class="col-md-6 mb-3">
                                        <label for="pooja-date">पूजा के लिए तारीख चुनें</label>
                                        <div class="availability">
                                            <input type="date" min="{{ date('Y-m-d') }}" name="date_availability"
                                                class="" id="datePicker" placeholder="पूजा के लिए तारीख चुनें"
                                                value="{{ request('date_availability') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="time">समय प्राथमिकता (वैकल्पिक)</label>
                                        <div class="availability">
                                            <input type="time" name="time" class=""
                                                placeholder="समय प्राथमिकता (वैकल्पिक)" value="{{ request('time') }}">
                                        </div>
                                    </div>
                                    @if ($is_available != 'yes')
                                    <div class="col-lg-12 col-12 px-0 text-end">
                                        <div class="form-submit mt-20">
                                            <button type="submit" class="theme-btn btn-style-one" id="selectButton"
                                                disabled>उपलब्धता जांचें</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-lg-4 col-xl-4">
                    <div class="product-details__buttons">
                        <div class="product-details__top">
                            <h3 class="product-details__title">Order Summary</h3>
                        </div>
                        <div class="table table-striped table-bordered tbl-shopping-cart">
                            @if (session()->get('pooja_language') == 'English')
                            <div class="col-12">
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
                                                        {{-- <li class="variation-size">City: <span>{{ $cart->city
                                                                }}</span>
                                                        </li>
                                                        <li class="variation-size">Pooja Type:
                                                            <span>{{ $cart->location }}</span>
                                                        </li>
                                                        <li class="variation-size">Packages:
                                                            <span>{{ $cart->package?->package_name }}</span>
                                                        </li> --}}
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
                                                        {{-- <li class="variation-size">
                                                            {{ $inclusion_data->inclusion }}:
                                                            <span>Included</span>
                                                        </li> --}}
                                                        @php
                                                        $total_inclusion +=
                                                        (int) $inclusion_data->price;
                                                        @endphp
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        {{-- <li>No inclusions available.</li> --}}
                                                        @endif

                                                        @php
                                                        $total = $cart->package?->discount_price + $total_inclusion;
                                                        $total_price += $total;
                                                        @endphp
                                                        @if ($product_type != 'temple')
                                                        {{-- <li class="variation-size">Priest Preference:
                                                            <span>{{ $cart->language }}</span>
                                                        </li> --}}
                                                        @endif
                                                        {{-- <li class="variation-size">Date & Time: <span>{{
                                                                $cart->date }}
                                                                &
                                                                {{ $cart->time }}</span></li> --}}
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
                                                <b>Pay Advance</b> <span id="advance_amount">Rs
                                                    {{ $pay_advance + $pay_advance_inclusion }}</span>
                                            </div>
                                            @endif
                                            @endif

                                        </div>
                                        <div class="full" id="full">
                                            <p class="total"><span id="total" class="advalet">Total</span>:
                                                <strong>Rs<span id="total_amount">
                                                        {{ $total_price }} </span></strong>
                                            </p>
                                        </div>
                                        <div class="advance" id="advance">
                                            <p><span class="advalet">Advance</span> : <strong>Rs
                                                    <span id="second_advance_amount">
                                                        {{ $pay_advance + $pay_advance_inclusion }}</span></strong></p>
                                            <p><span class="advalet">Remaining</span> : <strong>Rs<span
                                                        id="remaining_amount">
                                                        {{ $remaning_amount }}</span></strong></p>
                                            <p class="total"><span>Total</span>: <strong>Rs<span id="grand_total"> {{
                                                        $total_price }}
                                                    </span></strong></p>
                                        </div>


                                    </div>

                                    <input type="hidden" id="order_id" name="order_id" />
                                    <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" />

                                </div>
                            </div>
                            @else
                            <div class="billing-details">
                                <table class="table table-striped table-bordered cart-total"
                                    id="cart-total-table-hindi">
                                    <tbody id="cart-tbody-hindi">
                                        {{-- JS will inject here --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>कुल योग</td>
                                            <td>Rs <span id="total">0</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="ordercalculation">
                                    <div class="pay d-flex justify-content-between">
                                        <div class="payfullamount">
                                            <input type="radio" name="deposite_radio" value="pay_full"
                                                onclick="toggleContent(this)" checked>
                                            <b>पूरा भुगतान करें</b>
                                        </div>
                                    </div>
                                    <div class="full" id="full">
                                        <p class="total"><span class="advalet"> कुल : </span> <strong> Rs <span
                                                    id="total_amount">0</span></strong></p>
                                    </div>
                                    <div class="advance" id="advance">
                                        <p><span class="advalet">एडवांस</span> : <strong><span
                                                    id="advance_amount">0</span></strong></p>
                                        <p><span class="advalet">बाकी</span> : <strong><span
                                                    id="remaining_amount">0</span></strong></p>
                                        <p class="total"><span>कुल</span>: <strong><span
                                                    id="grand_total">0</span></strong>
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" id="order_id" name="order_id" />
                                <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" />
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            @include('frontend.package_order_summary')
                        </div>

                        {{-- <div class="ordercalculation">
                            <div class="pay d-flex justify-content-between">
                                <div class="payadvance">
                                    <input type="radio" name="deposit-radio" value="deposit"
                                        onclick="toggleContent(this)" checked>
                                    <b>Pay Advance</b> <span>Rs 1,700.00</span>
                                </div>
                                <div class="payfullamount">
                                    <input type="radio" name="deposit-radio" value="full" onclick="toggleContent(this)">
                                    <b>Pay Full Amount</b>
                                </div>
                            </div>
                            <div class="advance" id="advance">
                                <p><span class="advalet">Advance</span>: <strong><span>Rs 1,700.00</span></strong></p>
                                <p><span class="advalet">Remaining</span>: <strong><span>Rs 1,700.00</span></strong></p>
                                <p class="total"><span>Total</span>: <strong><span>Rs 4,800.00 </span></strong></p>
                            </div>

                            <div class="full" id="full">
                                <p class="total"><span class="advalet">Total</span>: <strong><span>Rs 4,800.00
                                        </span></strong></p>
                            </div>
                        </div> --}}
                        @if ($is_available == 'yes')
                        <div class="product-details__buttons-1 text-center">
                            <a href="{{ route('checkout') }}" class="theme-btn btn-style-one"><span class="btn-title">
                                    @if (session()->get('pooja_language') == 'English')
                                    Proceed To Checkout
                                    @else
                                    चेक आउट में जाएं
                                    @endif
                                    <i class="far fa-long-arrow-alt-right"></i>
                                </span></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    const datePicker = document.getElementById("datePicker");
        const selectButton = document.getElementById("selectButton");

        // Set the minimum date to today's date to disable previous dates
        const today = new Date().toISOString().split('T')[0];
        datePicker.setAttribute('min', today);

        // Detect change on the date input
        datePicker.addEventListener("change", function() {
            // Get the selected date in 'YYYY-MM-DD' format
            const selectedDate = datePicker.value;

            if (selectedDate) {
                // Split the date into components (YYYY-MM-DD)
                const [year, month, day] = selectedDate.split('-');

                // Format the date as DD/MM/YYYY
                const formattedDate = `${day}/${month}/${year}`;

                // Update button text
                @if (session()->get('pooja_language') == 'English')
                    selectButton.textContent = `Checkout : ${formattedDate}`;
                @else
                    selectButton.textContent = `उपलब्ध: ${formattedDate}`;
                @endif

                // Enable the button and add a custom class
                selectButton.disabled = false;
                selectButton.classList.add('date-selected'); // Adding the class
            }
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleButtons');
            const descriptionContent = document.getElementById('descriptionContents');
            const descriptionOverlay = document.getElementById('descriptionOverlays');

            toggleButton.addEventListener('click', function() {
                if (descriptionContent.classList.contains('show-full')) {
                    descriptionContent.classList.remove('show-full');
                    descriptionOverlay.style.display = 'block';
                    toggleButton.textContent = 'Show More';
                } else {
                    descriptionContent.classList.add('show-full');
                    descriptionOverlay.style.display = 'none';
                    toggleButton.textContent = 'Show Less';
                }
            });
        });
</script>

<script>
    function toggleContent(radio) {
            // Hide all content by default
            document.getElementById("advance").style.display = "none";
            document.getElementById("full").style.display = "none";

            // Show content based on the selected radio button
            if (radio.value === "deposit") {
                document.getElementById("advance").style.display = "block";
            } else if (radio.value === "full") {
                document.getElementById("full").style.display = "block";
            }
        }
</script>
<script>
    function set_location(id) {
            var location = $('#location').val();
            $.ajax({
                url: "{{ route('set_location') }}", // Laravel route
                type: "GET",
                data: {
                    location: location,
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = window.location.href;
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }

        function set_city_detail() {
            var city = $('#city').val();
            $.ajax({
                url: "{{ route('set_city') }}", // Laravel route
                type: "GET",
                data: {
                    city: city,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }


        function set_language_detail() {
            var language = $('#language').val();
            $.ajax({
                url: "{{ route('set_language') }}",
                type: "GET",
                data: {
                    pooja_language: language,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                    // console.log('Language set in session:', response.set_language);
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }
</script>

@endsection