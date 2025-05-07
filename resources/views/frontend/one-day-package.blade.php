@extends('frontend.layouts.app')
@section('content')
<div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        @if(session()->get('pooja_language')=='English')
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('one-day-puja.details', $product->slug) }}">E-Puja</a></li>
            <li class="breadcrumb-item"><a href="#">{{ $product->name }}</a></li>
            <li class="breadcrumb-item"> Package </li>
        </ul>
        @else
        <ul class="page-breadcrumb d-flex align-items-center">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">होम</a></li>
            <li class="breadcrumb-item"><a href="{{ route('one-day-puja.details', $product->slug) }}">ई-पूजा</a></li>
            <li class="breadcrumb-item"><a href="#">{{ $product->name_hindi }}</a></li>
            <li class="breadcrumb-item">पैकेज</li>
        </ul>

        @endif
    </div>
</div>
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
<section class="package-details">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-7 col-xl-7">
                @if(session()->get('pooja_language')=='English')
                <div class="product-info package_scroll">
                    <div class="product-details__top">
                        <h3 class="product-details__title">Select Inclusion</h3>
                    </div>
                    @foreach ($packages as $package)
                    @php
                    $cart_data_package = App\Models\Cart::where('user_id', $user_id)
                    ->where('product_id', $product->id)
                    ->where('package_id', $package->id)
                    ->first();
                    $inclusion_price = 0;
                    if (!empty($cart_data_package->id)) {
                    $inclusion_price = App\Models\Inclusion::whereIn(
                    'id',
                    json_decode($cart_data_package->inclusion),
                    )
                    ->get()
                    ->sum('price');
                    }
                    $final_price = $package->discount_price ?: $package->price;
                    $final_price += $inclusion_price;
                    @endphp
                    @foreach (App\Models\Inclusion::where('product_id', $package->product_id)->get() as $inclusion)
                    @php
                    $cart_data = App\Models\Cart::where('user_id', $user_id)
                    ->where('product_id', $product->id)
                    ->where('package_id', $package->id)
                    ->whereJsonContains('inclusion', (string) $inclusion->id)
                    ->first();

                    $uniqueKey = $package->id . '_' . $inclusion->id; // unique for this checkbox + button
                    @endphp

                    <div class="row puja_feeback_questions chadhawa-wrapper mt-3">
                        <div class="col-9 col-md-10 col-lg-9 col-xxl-10 chadhawa-item p-0">
                            <span>
                                <img src="{{ uploaded_asset($inclusion->image) }}"
                                    onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                            </span>
                            <div class="chadawa-title-amount">
                                <h2 class="chadhaw_title font_black_16 font_500">{{ $inclusion->inclusion }}</h2>
                                <div class="chadhwa_dis">{!! $inclusion->description_english !!}</div>
                            </div>
                        </div>

                        <div class="col-3 col-md-2 col-lg-3 col-xxl-2 text-end">
                            <div class="value prasad_li text-end">₹{{ $inclusion->price }}</div>

                            <!-- Hidden checkbox (for internal sync) -->
                            <input type="checkbox" id="inclusion_checkbox_{{ $uniqueKey }}"
                                class="inclusion-checkbox_{{ $package->id }}" value="{{ $inclusion->id }}"
                                style="display:none;" {{ !empty($cart_data->id) ? 'checked' : '' }}
                            />

                            <!-- Visible Toggle Button -->
                            <button type="button" id="toggle_button_{{ $uniqueKey }}"
                                class="btn btn-sm {{ !empty($cart_data->id) ? 'btn-danger' : 'btn-success' }}"
                                onclick="toggleInclusion('{{ $product->id }}', '{{ $package->id }}', '{{ $uniqueKey }}')"
                                data-inclusion-id="{{ $inclusion->id }}">
                                {{ !empty($cart_data->id) ? 'Remove' : 'Add' }}
                            </button>
                        </div>
                    </div>
                    @endforeach
                    <script>
                        // Helper to set cookie
                        function setCookie(name, value, minutes) {
                            const expires = new Date(Date.now() + minutes * 60 * 1000).toUTCString();
                            document.cookie = name + "=" + encodeURIComponent(value) + "; expires=" + expires + "; path=/";
                        }
                    
                        // Helper to get cookie
                        function getCookie(name) {
                            const cookies = document.cookie.split(';');
                            for (let i = 0; i < cookies.length; i++) {
                                const c = cookies[i].trim();
                                if (c.startsWith(name + "=")) {
                                    return decodeURIComponent(c.substring(name.length + 1));
                                }
                            }
                            return "";
                        }
                    
                        function toggleInclusion(productId, packageId, uniqueKey) {
                            const checkbox = document.getElementById('inclusion_checkbox_' + uniqueKey);
                            const button = document.getElementById('toggle_button_' + uniqueKey);
                            const inclusionId = button.getAttribute('data-inclusion-id');
                    
                            // Flip the checkbox
                            checkbox.checked = !checkbox.checked;
                    
                            // Update Cookie
                            updateCookieState(inclusionId, checkbox.checked);
                    
                            // Call cart logic
                            add_to_cart(productId, packageId);
                    
                            // Update button UI
                            updateButtonState(button, checkbox.checked);
                        }
                    
                        function updateButtonState(button, isChecked) {
                            if (isChecked) {
                                button.textContent = 'Remove';
                                button.classList.remove('btn-success');
                                button.classList.add('btn-danger');
                            } else {
                                button.textContent = 'Add';
                                button.classList.remove('btn-danger');
                                button.classList.add('btn-success');
                            }
                        }
                    
                        function updateCookieState(inclusionId, isChecked) {
                            let selected = getCookie('selected_inclusions');
                            let inclusionIds = selected ? JSON.parse(selected) : [];
                    
                            if (isChecked) {
                                if (!inclusionIds.includes(inclusionId)) {
                                    inclusionIds.push(inclusionId);
                                }
                            } else {
                                inclusionIds = inclusionIds.filter(id => id != inclusionId);
                            }
                    
                            setCookie('selected_inclusions', JSON.stringify(inclusionIds), 1); // Expires in 1 min
                        }
                    
                        function syncButtonsFromCookie() {
                            let selected = getCookie('selected_inclusions');
                            let inclusionIds = selected ? JSON.parse(selected) : [];
                    
                            document.querySelectorAll('button[id^="toggle_button_"]').forEach(button => {
                                const inclusionId = button.getAttribute('data-inclusion-id');
                                const checkbox = document.getElementById('inclusion_checkbox_' + button.id.replace('toggle_button_', ''));
                                if (!checkbox) return;
                    
                                if (inclusionIds.includes(inclusionId)) {
                                    checkbox.checked = true;
                                    updateButtonState(button, true);
                                } else {
                                    checkbox.checked = false;
                                    updateButtonState(button, false);
                                }
                            });
                        }
                    
                        document.addEventListener('DOMContentLoaded', syncButtonsFromCookie);
                        document.addEventListener('inertia:load', syncButtonsFromCookie);
                        document.addEventListener('inertia:finish', syncButtonsFromCookie);
                    </script>

                    @endforeach
                </div>
                @else
                <div class="product-info package_scroll">
                    <div class="product-details__top">
                        <h3 class="product-details__title">संकलन चुनें</h3>
                    </div>
                    @foreach ($packages as $package)
                    @php
                    $cart_data_package = App\Models\Cart::where('user_id', $user_id)
                    ->where('product_id', $product->id)
                    ->where('package_id', $package->id)
                    ->first();
                    $inclusion_price = 0;
                    if (!empty($cart_data_package->id)) {
                    $inclusion_price = App\Models\Inclusion::whereIn(
                    'id',
                    json_decode($cart_data_package->inclusion),
                    )
                    ->get()
                    ->sum('price');
                    }
                    $final_price = $package->discount_price ?: $package->price;
                    $final_price += $inclusion_price;
                    @endphp
                    @foreach (App\Models\Inclusion::where('product_id', $package->product_id)->get() as $inclusion)
                    @php
                    $cart_data = App\Models\Cart::where('user_id', $user_id)
                    ->where('product_id', $product->id)
                    ->where('package_id', $package->id)
                    ->whereJsonContains('inclusion', '' . $inclusion->id)
                    ->first();
                    @endphp
                    <div class="row puja_feeback_questions chadhawa-wrapper mt-3">
                        <div class="col-9 col-md-10 col-lg-9 col-xxl-10 chadhawa-item p-0">
                            <span>
                                <img src="{{ uploaded_asset($inclusion->image) }}"
                                    onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                            </span>
                            <div class="chadawa-title-amount">
                                <h2 class="chadhaw_title font_black_16 font_500">
                                    {{ $inclusion->inclusion_hindi }} </h2>
                                <div class="chadhwa_dis">{!! $inclusion->description_hindi !!}</div>
                            </div>
                        </div>
                        <div class="col-3 col-md-2 col-lg-3 col-xxl-2 text-end">
                            <div class="value prasad_li text-end">
                                ₹{{ $inclusion->price }}
                            </div>
                            <button type="button" class="btn btn-sm btn-success">
                                <input type="checkbox" class="inclusion-checkbox_{{ $package->id }}"
                                    onclick="add_to_cart('{{ $product->id }}','{{ $package->id }}')"
                                    value="{{ $inclusion->id }}" @if (!empty($cart_data->id)) checked @endif />
                                + जोड़ें
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col-lg-5 col-xl-5">
                <div class="product-details__buttons">
                    <div class="product-details__top">
                        <h3 class="product-details__title">@if(session()->get('pooja_language')=='English') Order
                            Summary @else आर्डर सारांश @endif</h3>
                    </div>
                    <div class="table-responsive" id="order_summary">
                        @include('frontend.e-package_order_summary')
                    </div>

                    <div class="product-details__buttons-1 text-center button-fixed">
                        <a href="{{ route('one_day_product_package.checkout') }}"
                            class="theme-btn btn-style-one w-100"><span class="btn-title">
                                @if(session()->get('pooja_language')=='English') Proceed to Checkout @else चेकआउट के लिए
                                आगे बढ़ें @endif <i class="far fa-long-arrow-alt-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
@endsection