@extends('frontend.layouts.app')
@section('content')
    <div class="auto-container">
        <div class="section-cart">
            <div class="row mb-3">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="border-bottom bg-transparent card-header">
                                    <h6 class="header-title mb-0">Order #{{ $order->code }}</h6>
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
                                                        <h6 class="mt-0">#{{ $order->code }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="d-flex mb-2">
                                                    <div class="me-2 align-self-center"><i
                                                            class="ri-user-2-line h2 m-0 text-muted"></i></div>
                                                    <div class="flex-1">
                                                        <p class="mb-1">Billing Name</p>
                                                        <h6 class="mt-0">{{ $order->user->name }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="d-flex mb-2">
                                                    <div class="me-2 align-self-center">
                                                        <i class="ri-calendar-event-line h2 m-0 text-muted"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="mb-1">Date</p>
                                                        <p class="mt-0">{{ $order->created_at }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="border-bottom bg-transparent card-header">
                                    <h6 class="header-title mb-0">Payment Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="mb-0 table table-sm table-borderless">
                                        <tbody>
                                            <tr>
                                                <th>Payment Type :</th>
                                                <td>{{ $order->payment_type }} </td>
                                            </tr>
                                            <tr>
                                                <th>Payment Details:</th>
                                                <td>
                                                    @if (!empty($order->payment_details))
                                                        {{ json_decode($order->payment_details)->id }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="table-responsive">
                        <table class="table table-bordered cart-total">
                            <tbody>
                                <tr>
                                    <td>Package : {{$order->package_name}}</td>
                                    <td class="product-name">
                                        Rs<span>
                                            {{$order->price}}
                                        </span>
                                    </td>
                                </tr>
                                @if(count(json_decode($order->inclusion_price))>0)
                                @foreach(json_decode($order->inclusion_price) as $key=>$price)
                                @php $inclusion=App\Models\Inclusion::find(json_decode($order->inclusion)[$key]) @endphp
                                <tr>
                                    <td>{{$inclusion->inclusion}}</td>
                                    <td>
                                        <p> Rs {{$price}}</p>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @if($order->dakshina > 0)
                                <tr>
                                    <td>Dakshina</td>
                                    <td>Rs <span id="dakshina_total">{{$order->dakshina}}</span>
                                    </td>
                                </tr>
                                @endif
                                @if($order->prashad_price > 0)
                                <tr>
                                    <td>Prashad Price</td>
                                    <td>Rs <span id="prashad_price">{{$order->prashad_price}}</span>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Total</td>
                                    <td>Rs <span >{{$order->total_paid}}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
