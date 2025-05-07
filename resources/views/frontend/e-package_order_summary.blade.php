<table class="table table-striped table-bordered tbl-shopping-cart">
    @if(session()->get('pooja_language')=='English')
    <tbody>

        <tr>
            <td class="product-price"><span class="pooja">Pooja Name</span></td>
            <td class="product-price"><span
                    class="{{ $product->name }}">{{ $product->name }}</span></td>
        </tr>
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
        @php
            $cart_data_order_package = App\Models\Cart::where('user_id', $user_id)
                ->where('product_id', $product->id)
                ->first();
            if ($cart_data_order_package && !empty($cart_data_order_package->id)) {
                $package_data = App\Models\Package::where(
                    'id',
                    $cart_data_order_package->package_id,
                )->first();
                $inclusion_data = App\Models\Inclusion::whereIn(
                    'id',
                    $cart_data_order_package->inclusion
                        ? json_decode($cart_data_order_package->inclusion)
                        : [],
                )->get();
            }
        @endphp
        @if (!empty($cart_data_order_package->id))
            <tr>
                <td class="product-price"><span class="pooja">Package Name</span></td>
                <td class="product-price"><span>{{ $package_data?->package_name }}</span></td>
            </tr>
            @if ($inclusion_data->count() > 0)
                @foreach ($inclusion_data as $inclu)
                    <tr>
                        <td class="product-price"><span
                                class="pooja">{{ $inclu->inclusion }}</span></td>
                        <td class="product-price"><span>Included</span></td>
                    </tr>
                @endforeach
            @endif
        @endif
    </tbody>
    @else
    <tbody>

        <tr>
            <td class="product-price"><span class="pooja">पूजा का नाम</span></td>
            <td class="product-price"><span class="{{ $product->name_hindi }}">{{ $product->name_hindi }}</span></td>
        </tr>
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
        @php
            $cart_data_order_package = App\Models\Cart::where('user_id', $user_id)
                ->where('product_id', $product->id)
                ->first();
            if ($cart_data_order_package && !empty($cart_data_order_package->id)) {
                $package_data = App\Models\Package::where(
                    'id',
                    $cart_data_order_package->package_id,
                )->first();
                $inclusion_data = App\Models\Inclusion::whereIn(
                    'id',
                    $cart_data_order_package->inclusion
                        ? json_decode($cart_data_order_package->inclusion)
                        : [],
                )->get();
            }
        @endphp
        @if (!empty($cart_data_order_package->id))
            <tr>
                <td class="product-price"><span class="pooja">पैकेज का नाम</span></td>
                <td class="product-price"><span>{{ $package_data?->package_name_hindi }}</span></td>
            </tr>
            @if ($inclusion_data->count() > 0)
                @foreach ($inclusion_data as $inclu)
                    <tr>
                        <td class="product-price"><span class="pooja">{{ $inclu->inclusion_hindi }}</span></td>
                        <td class="product-price"><span>शामिल है</span></td>
                    </tr>
                @endforeach
            @endif
        @endif
    </tbody>

    @endif
</table>
