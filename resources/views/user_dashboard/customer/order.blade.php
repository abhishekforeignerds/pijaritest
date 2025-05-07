@extends('user_dashboard.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-9 col-9">
                                        <h4 class="page-title">Orders</h4>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <tr>
                                                <th scope="col">ORDER CODE</th>
                                                <th scope="col">POOJA NAME</th>
                                                <th scope="col">POOJA DATE</th>
                                                <th scope="col">POOJA TYPE</th>
                                                <th scope="col">POOJA LOCATION</th>
                                                <th scope="col">TOTAL AMOUNT</th>
                                                <th scope="col">PAID AMOUNT</th>
                                                <th scope="col">STATUS</th>
                                                <th scope="col">ACTION</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->code }}</td>
                                            <td>{{ $order->order_detail[0]->product_name }}</td>
                                            <td>{{ $order->order_detail[0]->date }}</td>
                                            <td>@if($order->order_detail[0]->product->product_type=='temple'){{ 'Terth Puja' }} @else All Puja @endif</td>
                                            <td>{{ $order->order_detail[0]->location }}</td>
                                            <td>₹{{ $order->grand_total }}</td>
                                            <td>₹{{ $order->total_paid }}</td>
                                            <td> @if(!empty($order->order_detail[0]->pujari_status)) {{ $order->order_detail[0]->pujari_status}} @else Pending @endif</td>
                                            <td>
                                                <div class="d-flex order-actions">
                                                    <a href="{{route('user.customer_order_show',$order->id)}}" class="rbt-btn btn-md">View</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr class="footable-empty">
                                                <td colspan="11">
                                                    <center style="padding: 70px;"><i class="far fa-frown" style="font-size: 100px;"></i><br>
                                                        <h2>Nothing Found</h2>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
