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
                                        <th scope="col">SERVICE ORDER CODE</th>
                                        {{-- <th scope="col">VENDOR</th> --}}
                                        <th scope="col">AMOUNT</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->code }}</td>
                                    {{-- <td>{{ $order->vendor->firm_name }}</td> --}}
                                    <td>₹{{ $order->grand_total }}</td>
                                    <td>{{ $order->delivery_status }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="{{route('vendor.service_order_show',$order->id)}}" class=""><i class="bx bxs-edit"></i></a>
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
