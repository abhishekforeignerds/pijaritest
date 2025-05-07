@extends('pujari_dashboard.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Puja List</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
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


                                                                </tr>
                                                            </thead>
                                                            <tbody>

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

                        </div>
                        <div class="col-lg-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@section('script')

@endsection
