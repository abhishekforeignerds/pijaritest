@extends('frontend.layouts.app')
@section('content')
{{-- <section class="page-title">
    <div class="auto-container">
        <div class="title-outer text-center">
            <h1 class="title">Order Confirmation</h1>
            <ul class="page-breadcrumb">
                <li><a href="/">Home</a></li>
                <li>Order Confirmation</li>
            </ul>
        </div>
    </div>
</section> --}}

<section>
    <div class="auto-container">
        <div class="section-cart">
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
                                                        @if($order->wallet_discount)
                                                        <tr>
                                                            <th scope="row">Wallet Discount :</th>
                                                            <td>₹{{$order->wallet_discount}}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <th scope="row">Total Paid:</th>
                                                            <td>₹{{$order->total_paid}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Remaning:</th>
                                                            <td>₹{{$order->grand_total-$order->total_paid}}</td>
                                                        </tr>
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
                                        <td>{{ json_decode($order->shipping_address)->address }},{{
                                            json_decode($order->shipping_address)->city }},{{
                                            json_decode($order->shipping_address)->pincode }},{{
                                            json_decode($order->shipping_address)->state }}
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
                                        <td>@if(!empty($order->payment_details)){{json_decode($order->payment_details)->id}}@endif
                                        </td>
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
                                                                        <h6 class="m-0">{{$order_detail->product_name}}
                                                                        </h6>
                                                                        <p>@foreach(json_decode($order_detail->inclusion)
                                                                            as $inclusions)
                                                                            {{App\Models\Inclusion::find($inclusions)->inclusion}},
                                                                            @endforeach</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{$order_detail->package_name}}</td>
                                                            <td>₹{{ $order_detail->price }}</td>
                                                            @if(!empty($order_detail->inclusion_price))

                                                            <td> @foreach(json_decode($order_detail->inclusion_price) as
                                                                $price) +₹{{$price}} @endforeach</td>
                                                            @endif
                                                            <td>
                                                                Puja Date : {{$order_detail->date}}<br>
                                                                Puja Time : {{$order_detail->time}}<br>
                                                                Pooja Type : {{$order_detail->location}}<br>
                                                                Pooja City : {{$order_detail->city}}<br>
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
                    @if($order_detail->location=='online')
                    <div class="p-2 mb-lg-0 card">
                        <div class="">
                            <div class="my-2">
                                <h4>Sankalp Details</h4>
                            </div>
                            <div class="mt-2 pt-1">
                                <p class="mb-0"><span class="fw-semibold">Rashi Name :</span>
                                    {{ $order->rashi_name }}</p>
                                <p class="mb-0"><span class="fw-semibold">DOB :</span>
                                    {{ $order->dob }}</p>
                                <p class="mb-0"><span class="fw-semibold">Gotra :</span>
                                    {{ $order->gotra }}</p>
                                <p class="mb-0"><span class="fw-semibold">Community :</span>
                                    {{ $order->varn }}</p>
                                <p class="mb-0"><span class="fw-semibold">Wife Name :</span>
                                    {{ $order->wife_name }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-4">
                </div>
                <div class="col-lg-4">
                    {{-- <div>

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
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>




@endsection