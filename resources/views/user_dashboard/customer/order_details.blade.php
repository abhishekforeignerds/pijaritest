@extends('user_dashboard.layouts.app')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="page-content">
                <div class="">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label for="Category" class="form-label">Payment Status</label>
                                                <select class="form-select" aria-label="Payment Status" name="payment_status"
                                                    id="payment_status"  disabled>
                                                    <option>Select Payment Status</option>
                                                    <option value="paid"
                                                        @if ($order->payment_status == 'paid') {{ 'selected' }} @endif>Paid
                                                    </option>
                                                    <option value="unpaid"
                                                        @if ($order->payment_status == 'unpaid') {{ 'selected' }} @endif>Unpaid
                                                    </option>
                                                    <option value="cancel"
                                                    @if ($order->payment_status == 'cancel') {{ 'selected' }} @endif>Cancel
                                                </option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="border-bottom bg-transparent card-header">
                                    <h6 class="header-title mb-0">Order #{{$order->code}}</h6>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="d-flex mb-2">
                                                    <div class="me-2 align-self-center"><i
                                                            class="ri-hashtag h2 m-0 text-muted"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="mb-1">ID No.</p>
                                                        <h6 class="mt-0">#{{$order->code}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="d-flex mb-2">
                                                    <div class="me-2 align-self-center"><i
                                                            class="ri-user-2-line h2 m-0 text-muted"></i></div>
                                                    <div class="flex-1">
                                                        <p class="mb-1">Billing Name</p>
                                                        <h6 class="mt-0">{{$order->user->name}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="d-flex mb-2">
                                                    <div class="me-2 align-self-center"><i
                                                            class="ri-calendar-event-line h2 m-0 text-muted"></i></div>
                                                    <div class="flex-1">
                                                        <p class="mb-1">Date</p>
                                                        <h6 class="mt-0">{{$order->created_at}}</small>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table table-centered border mb-0 table">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th colspan="2">Order summary</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Total :</th>
                                                                    <td>₹{{$order->grand_total}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Total Paid:</th>
                                                                    <td>₹{{$order->total_paid}}</td>
                                                                </tr>
                                                                @if($order->wallet_discount)
                                                                <tr>
                                                                    <th scope="row">Wallet Discount :</th>
                                                                    <td>₹{{$order->wallet_discount}}</td>
                                                                </tr>
                                                                @endif
                                                                {{-- <tr>
                                                                    <th scope="row">Grand Total :</th>
                                                                    <td>₹{{$order->grand_total - $order->wallet_discount}}</td>
                                                                </tr> --}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="border-bottom bg-transparent card-header">
                                    <h6 class="header-title mb-0">Shipping Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="mb-0 table table-sm table-borderless">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Name :</th>
                                                <td>{{ json_decode($order->shipping_address)->name }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Address:</th>
                                                <td>{{ json_decode($order->shipping_address)->address }},{{ json_decode($order->shipping_address)->city }},{{ json_decode($order->shipping_address)->pincode }},{{ json_decode($order->shipping_address)->state }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Phone :</th>
                                                <td>{{ json_decode($order->shipping_address)->phone }} </td>
                                            </tr>
                                            @if(!empty(json_decode($order->shipping_address)->email))
                                            <tr>
                                                <th scope="row">Email :</th>
                                                <td>{{ json_decode($order->shipping_address)->email }} </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="border-bottom bg-transparent card-header">
                                    <h6 class="header-title mb-0">Payment Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="mb-0 table table-sm table-borderless">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Payment Type :</th>
                                                <td>{{ $order->payment_type }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Payment Details:</th>
                                                <td>@if(!empty($order->payment_details)){{json_decode($order->payment_details)->id}}@endif</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mt-2">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table-centered border table-nowrap mb-lg-0 table">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th>Product</th>
                                                                    <th>Package Name</th>
                                                                    <th>Price</th>
                                                                    <th>Inclusion</th>
                                                                    <th>Puja Info</th>
                                                                    <th>Assign Pujari</th>
                                                                    <th>Pujari Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($order->order_detail as $order_detail)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="me-3"><img
                                                                                        src="{{$order_detail->product_image}}"
                                                                                        alt="" style="height: 56px;"></div>
                                                                                <div class="flex-1">
                                                                                    <h6 class="m-0">{{$order_detail->product_name}}</h6>
                                                                                    <p>@foreach(json_decode($order_detail->inclusion) as $inclusions) {{App\Models\Inclusion::find($inclusions)->inclusion}}, @endforeach</p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>{{$order_detail->package_name}}</td>
                                                                        <td>₹{{ $order_detail->price }}</td>
                                                                        @if(!empty($order_detail->inclusion_price))

                                                                        <td>  @foreach(json_decode($order_detail->inclusion_price) as $price) +₹{{$price}}  @endforeach</td>
                                                                        @endif
                                                                        <td>
                                                                         Puja Date : {{$order_detail->date}}<br>
                                                                         Puja Time :   {{$order_detail->time}}<br>
                                                                         Location  : {{$order_detail->location}}<br>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-select" aria-label="Pujari Ji" name="pujari_ji" id="pujari_ji_{{$order_detail->id}}"  disabled >
                                                                                <option>Select Pujari Ji</option>
                                                                                @foreach(App\Models\Pujari::get() as $pujari)
                                                                                    <option value="{{$pujari->id}}" @if($order_detail->pujari_id==$pujari->id) selected @endif>{{$pujari->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                           @if(!empty($order_detail->pujari_status)) {{$order_detail->pujari_status}} @else Pending @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">

                        <div class="col-lg-4">

                        </div>
                        <div class="col-lg-4">
                            <div>

                                <div class="p-2 mb-lg-0 card">
                                    <div class="text-center">
                                        <div class="my-2"><i class="mdi mdi-truck-fast h1 text-muted"></i></div>
                                        <div class="mt-2 pt-1">
                                            <p class="mb-0"><span class="fw-semibold">Payment Mode :</span>
                                                {{ $order->payment_type }}</p>
                                                <p class="mb-0"><span class="fw-semibold">Payment Status :</span>
                                                    {{ $order->payment_status }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
