@extends('user_dashboard.layouts.app')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Service Order Detail</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="border-bottom bg-transparent card-header">
                            <h5 class="header-title mb-0">Order #{{$order->code}}</h5>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex mb-2">
                                            <div class="me-2 align-self-center"><i
                                                    class="ri-hashtag h2 m-0 text-muted"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="mb-1">ID No.</p>
                                                <h5 class="mt-0">#{{$order->code}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex mb-2">
                                            <div class="me-2 align-self-center"><i
                                                    class="ri-user-2-line h2 m-0 text-muted"></i></div>
                                            <div class="flex-1">
                                                <p class="mb-1">Billing Name</p>
                                                <h5 class="mt-0">{{$order->user->name}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex mb-2">
                                            <div class="me-2 align-self-center"><i
                                                    class="ri-calendar-event-line h2 m-0 text-muted"></i></div>
                                            <div class="flex-1">
                                                <p class="mb-1">Date</p>
                                                <h5 class="mt-0">{{$order->created_at}}</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="d-flex mb-2">
                                            <div class="me-2 align-self-center"><i
                                                    class="ri-calendar-event-line h2 m-0 text-muted"></i></div>
                                            <div class="flex-1">
                                                <p class="mb-1">Vendor</p>
                                                <h5 class="mt-0">{{$order->vendor->firm_name}}</small>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table-centered border table-nowrap mb-lg-0 table">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Service</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <td>{{$order->service_name}}</td>
                                                            <td>1</td>
                                                            <td>₹{{$order->price}}<del> ₹{{$order->mrp}}</del></td>
                                                            <td>₹{{$order->price}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
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
                    <div>
                        <h4 class="font-15 mb-2">Shipping Information</h4>
                        <div class="p-2 mb-lg-0 card">
                            <table class="mb-0 table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name :</th>
                                        <td>{{json_decode($order->shipping_address)->name}} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Address:</th>
                                        <td>{{json_decode($order->shipping_address)->address}},{{json_decode($order->shipping_address)->city}},{{json_decode($order->shipping_address)->pincode}},{{json_decode($order->shipping_address)->state}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone :</th>
                                        <td>{{json_decode($order->shipping_address)->phone}} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
                <div class="col-lg-4">
                    <div>
                        <h4 class="font-15 mb-2">Delivery Info</h4>
                        <div class="p-2 mb-lg-0 card">
                            <div class="text-center">
                                <div class="my-2"><i class="mdi mdi-truck-fast h1 text-muted"></i></div>
                                <div class="mt-2 pt-1">
                                    <p class="mb-0"><span class="fw-semibold">Payment Mode :</span> {{$order->payment_type}}</p>
                                    <p class="mb-0"><span class="fw-semibold">Status :</span> {{$order->delivery_status}}</p>
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
