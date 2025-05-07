@php
// Determine current user or guest ID
$user_id = Auth::check() ? Auth::user()->id : Session::get('guest_id', 0);
@endphp

<div class="row">
    @foreach ($packages as $package)
    @php
    // Check if this package is already in cart
    $inCart = App\Models\Cart::where('user_id', $user_id)
    ->where('product_id', $product->id)
    ->where('package_id', $package->id)
    ->exists();

    // Calculate final price (discount + inclusions removed for simplicity)
    $finalPrice = $package->discount_price ?: $package->price;
    @endphp

    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                {{-- Package Title --}}
                <h5 class="card-title">
                    {{ session('pooja_language') == 'Hindi' ? $package->package_name_hindi : $package->package_name }}
                </h5>

                {{-- Package Description --}}
                <p class="card-text description mb-4">
                    {!! session('pooja_language') == 'Hindi' ? $package->description_hindi : $package->description !!}
                </p>

                <div class="mt-auto">
                    {{-- Price Display --}}
                    <p class="h5 text-success mt-4">
                        ₹{{ number_format($finalPrice, 2) }}
                        @if($package->discount_price)
                        <br><small class="text-muted"><del>₹{{ number_format($package->price, 2) }}</del></small>
                        @endif
                    </p>

                    {{-- Select / Selected Button --}}
                    @if($inCart)
                    <button style="padding:0.75rem 1.5rem" type="button" class="btn btn-success btn-block  w-100"
                        disabled>Selected</button>
                    @else
                    <button type="button" class="theme-btn btn-style-one w-100"
                        onclick="add_to_cart('{{ $product->id }}', '{{ $package->id }}')">
                        Select
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    .description {
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>