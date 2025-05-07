@extends('frontend.layouts.app')
@section('content')
    <section>
        <div class="auto-container">
            @if (session()->get('pooja_language') == 'English')
                <div class="section-cart">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered tbl-shopping-cart">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Photo</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total_price = 0; @endphp
                                        @foreach ($carts as $cart)
                                            <tr class="cart_item">
                                                <td class="product-remove"><a title="Remove this item" class="remove"
                                                        href="javascript:void(0);" data-id="{{ $cart->id }}">×</a></td>
                                                <td class="product-thumbnail"><a href="#"><img
                                                            src="{{ $cart->product->full_image_url }}"></a></td>
                                                <td class="product-name"><a href="#">{{ $cart->product->name }}</a>
                                                    <ul class="variation">
                                                        <li class="variation-size">City: <span>{{ $cart->city }}</span>
                                                        </li>
                                                        <li class="variation-size">Pooja Type:
                                                            <span>{{ $cart->location }}</span></li>
                                                        <li class="variation-size">Packages:
                                                            <span>{{ $cart->package?->package_name }}</span></li>
                                                        @php $total_inclusion = 0; @endphp
                                                        @if ($cart->inclusion && count(json_decode($cart->inclusion)) > 0)
                                                            @foreach (json_decode($cart->inclusion) as $inclusion)
                                                                @php
                                                                    $inclusion_data = App\Models\Inclusion::find(
                                                                        $inclusion,
                                                                    );
                                                                    $total_inclusion += $inclusion_data->price ?? 0; // Accumulate inclusion prices
                                                                @endphp
                                                                <li class="variation-size">Included :
                                                                    <span>{{ $inclusion_data->inclusion }}</span></li>
                                                            @endforeach
                                                        @endif
                                                        <li class="variation-size">Priest Preference:
                                                            <span>{{ $cart->language }}</span></li>
                                                        <li class="variation-size">Date & Time: <span>{{ $cart->date }} &
                                                                {{ $cart->time }}</span></li>
                                                    </ul>
                                                </td>
                                                @php
                                                    $total = ($cart->package?->discount_price ?? 0) + $total_inclusion;
                                                    $total_price += $total;
                                                @endphp
                                                <td class="product-price">
                                                    <span class="amount">Rs {{ $cart->package?->discount_price }}</span>
                                                    @php
                                                        $inclusions = json_decode($cart->inclusion);
                                                    @endphp

                                                    @if (isset($inclusions) && is_array($inclusions) && count($inclusions) > 0)
                                                        @foreach ($inclusions as $inclusion)
                                                            @php
                                                                $inclusion_data = App\Models\Inclusion::find(
                                                                    $inclusion,
                                                                );
                                                            @endphp
                                                            <br>
                                                            <span class="amount">Rs
                                                                {{ $inclusion_data->price ?? '0' }}</span>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="product-subtotal"><span class="amount">Rs
                                                        {{ $total }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4 class="pb-10">Cart Totals</h4>
                            <table class="table table-bordered cart-total">
                                <tbody>
                                    <tr>
                                        <td><b>Cart Subtotal</b></td>
                                        <td>Rs {{ $total_price }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>To Pay</b></td>
                                        <td>Rs {{ $total_price }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a class="theme-btn btn-style-one" href="{{ route('checkout') }}"><span
                                    class="btn-title">Proceed to Checkout</span></a>
                        </div>
                    </div>
                </div>
            @else
                <div class="section-cart">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered tbl-shopping-cart">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>फोटो</th>
                                            <th>पूजा का नाम</th>
                                            <th>कीमत</th>
                                            <th>कुल</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total_price = 0; @endphp
                                        @foreach ($carts as $cart)
                                            <tr class="cart_item">
                                                <td class="product-remove"><a title="इस आइटम को हटाएं" class="remove"
                                                        href="javascript:void(0);" data-id="{{ $cart->id }}">×</a></td>
                                                <td class="product-thumbnail"><a href="#"><img
                                                            src="{{ $cart->product->full_image_url }}"></a></td>
                                                <td class="product-name"><a href="#">{{ $cart->product->name_hindi }}</a>
                                                    <ul class="variation">
                                                        @php $city_name=App\Models\ServiceCity::where('city',session()->get('city'))->first(); @endphp
                                                        <li class="variation-size">शहर: <span>@if(!empty($city_name->city_name_hindi)) {{$city_name->city_name_hindi}} @else {{session()->get('city')}} @endif</span>
                                                        </li>
                                                        <li class="variation-size">पूजा स्थान:
                                                            <span>@if ($cart->location == 'online') ऑनलाइन @endif @if ($cart->location == 'home')  मेरे घर पर  @endif</span></li>
                                                        <li class="variation-size">पैकेज:
                                                            <span>{{ $cart->package?->package_name_hindi }}</span></li>
                                                        @php $total_inclusion = 0; @endphp
                                                        @if ($cart->inclusion && count(json_decode($cart->inclusion)) > 0)
                                                            @foreach (json_decode($cart->inclusion) as $inclusion)
                                                                @php
                                                                    $inclusion_data = App\Models\Inclusion::find(
                                                                        $inclusion,
                                                                    );
                                                                    $total_inclusion += $inclusion_data->price ?? 0; // शामिल कीमतें जोड़ें
                                                                @endphp
                                                                <li class="variation-size">
                                                                    समावेश  : <span> {{ $inclusion_data->inclusion_hindi }} </span>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                        <li class="variation-size">पुजारी भाषा:
                                                            <span>{{ $cart->language }}</span></li>
                                                        <li class="variation-size">तिथि और समय: <span>{{ $cart->date }} &
                                                                {{ $cart->time }}</span></li>
                                                    </ul>
                                                </td>
                                                @php
                                                    $total = ($cart->package?->discount_price ?? 0) + $total_inclusion;
                                                    $total_price += $total;
                                                @endphp
                                                <td class="product-price">
                                                    <span class="amount">रु {{ $cart->package?->discount_price }}</span>
                                                    @php
                                                        $inclusions = json_decode($cart->inclusion);
                                                    @endphp

                                                    @if (isset($inclusions) && is_array($inclusions) && count($inclusions) > 0)
                                                        @foreach ($inclusions as $inclusion)
                                                            @php
                                                                $inclusion_data = App\Models\Inclusion::find(
                                                                    $inclusion,
                                                                );
                                                            @endphp
                                                            <br>
                                                            <span class="amount">रु
                                                                {{ $inclusion_data->price ?? '0' }}</span>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="product-subtotal"><span class="amount">रु
                                                        {{ $total }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4 class="pb-10">कार्ट का कुल</h4>
                            <table class="table table-bordered cart-total">
                                <tbody>
                                    <tr>
                                        <td><b>कुल राशि</b></td>
                                        <td>रु {{ $total_price }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>भुगतान करने के लिए</b></td>
                                        <td>रु {{ $total_price }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a class="theme-btn btn-style-one" href="{{ route('checkout') }}"><span
                                    class="btn-title">चेकआउट पर जाएं</span></a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.remove').forEach(function(button) {
            button.addEventListener('click', function() {
                const cartId = this.getAttribute('data-id');

                if (confirm('Are you sure you want to remove this item?')) {
                    fetch(`/cart/remove/${cartId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Item removed successfully');
                                location.reload();
                            } else {
                                alert('Failed to remove the item. Please try again.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    });
</script>
