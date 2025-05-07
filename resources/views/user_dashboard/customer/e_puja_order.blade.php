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
                                        <h4 class="page-title">E-puja Orders</h4>
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
                                                <th scope="col">DATE</th>
                                                <th scope="col">PUJA DATE</th>
                                                <th scope="col">PUJA NAME</th>
                                                <th scope="col">PACKAGE</th>
                                                <th scope="col">AMOUNT</th>
                                                <th scope="col">DAKSHINA</th>
                                                <th scope="col">PAYMENT</th>
                                                <th scope="col">ACTION</th>

                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->code }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->product->date }}</td>
                                            <td>{{ $order->product_name }}</td>
                                            <td>{{ $order->package_name }}</td>
                                            <td>₹{{ $order->grand_total }}</td>
                                            <td>₹{{ $order->dakshina }}</td>
                                            <td>
                                                @if ($order->payment_status == 'paid')
                                                    <p class="text-success">Paid</p>
                                                @else
                                                    <p class="text-danger">UnPaid</p>
                                                @endif
                                            </td>
                                            <td>
                                                 <div class="d-flex order-actions">
                                                    <a href="{{route('user.customer_e_puja_order_show',$order->id)}}" class="rbt-btn btn-md">View</a>
                                                 </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="footable-empty">
                                            <td colspan="11">
                                                <center style="padding: 70px;"><i class="far fa-frown"
                                                        style="font-size: 100px;"></i><br>
                                                    <h2>Nothing Found</h2>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
