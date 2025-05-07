@extends('vendor_dashboard.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Order List</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <tr>
                                        <th scope="col">ORDER CODE</th>
                                        <th scope="col">NUM. OF PRODUCTS</th>
                                        {{-- <th scope="col">VENDOR</th> --}}
                                        <th scope="col">AMOUNT</th>
                                        <th scope="col">ADMIN TO PAY</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ count($order->order_detail) }}</td>
                                    {{-- <td>{{ $order->vendor->firm_name }}</td> --}}
                                    <td>₹{{ $order->grand_total }}</td>
                                    <td>
                                        @if(!empty($order->payment_details))
                                          @if($order->vendor_paid==1)
                                            Paid
                                          @else
                                            Unpaid
                                          @endif
                                        @else
                                          Offline Payment
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="{{route('vendor.order_show',$order->id)}}" class=""><i class="bx bxs-edit"></i></a>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
