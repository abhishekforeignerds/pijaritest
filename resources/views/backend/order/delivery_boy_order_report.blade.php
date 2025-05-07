@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Order Product List</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <form method="GET" id="order_form" action="{{ route('admin.delivery_boy_order_report') }}">
                            <tr>
                                <td>
                                    <div class="mb-3">
                                        <input type="date" class="form-control" name="daterange" onchange="filter()"
                                            placeholder="Date Filter" value="{{ $dateRange }}" />
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3">
                                        <select class="form-select" aria-label="Payment Status" name="delivery_status"
                                                id="delivery_status" onchange="filter()" >
                                                <option value="">Delivery Status</option>
                                                <option value="pending" @if($delivery_status=='pending') selected @endif>Pending</option>
                                                <option value="confirmed" @if($delivery_status=='confirmed') selected @endif>Confirmed</option>
                                                <option value="shipped" @if($delivery_status=='shipped') selected @endif>Shipped</option>
                                                <option value="delivered" @if($delivery_status=='delivered') selected @endif>Delivered</option>
                                                <option value="cancelled" @if($delivery_status=='cancelled') selected @endif>Cancelled</option>
                                            </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-success" onclick="printTable()" >Print</button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                    </table>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered" style="width:99%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">PRODUCT NAME</th>
                                    <th scope="col" class="text-center">PRODUCT SKU</th>
                                    <th scope="col" class="text-center">QUANTITY</th>
                                    <th scope="col" class="text-center">DATE</th>
                                    <th scope="col" class="text-center">TIME</th>
                                    <th scope="col" class="text-center">DELIVERY BOY</th>
                                    <th scope="col" class="text-center">DELIVERY STATUS</th>

                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @forelse ($orders as $order)
                                 @foreach(App\Models\OrderSubscription::where('delivery_boy_id',$order->delivery_boy_id)->where('date',$dateRange)->get() as $product_order)
                                    <tr>
                                        <td class="text-center">{{  optional($product_order->order_detail)->product_name }}</td>
                                        <td class="text-center">@if(!empty($product_order->order_detail->product_stock->sku)){{  $product_order->order_detail->product_stock->sku }}@endif</td>
                                        <td class="text-center">
                                            @if(!empty($dateRange))
                                            {{ App\Models\OrderSubscription::where('product_variant_id',$product_order->product_variant_id)->where('date',$dateRange)->where('delivery_boy_id',$product_order->delivery_boy_id)->sum('quantity') }}
                                            @else
                                            {{ App\Models\OrderSubscription::where('product_variant_id',$product_order->product_variant_id)->where('delivery_boy_id',$product_order->delivery_boy_id)->sum('quantity') }}
                                            @endif</td>
                                            <td class="text-center">{{ $product_order->date }}</td>
                                            <td class="text-center">{{ $product_order->delivery_time }}</td>
                                            <td class="text-center">{{ optional($product_order->delivery_boy)->name }}</td>

                                        <td class="text-center">{{ $product_order->status }}</td>
                                    </tr>
                                 @endforeach
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
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('backend/plugins/select2/js/select2-custom.js') }}"></script>
<script>

    function filter() {
        $('#order_form').submit();
    }

    function printTable() {
    var divToPrint = document.querySelector('.table-responsive');
    var newWin = window.open('');
    newWin.document.write('<html><head><title>Print</title>');
    newWin.document.write('<link rel="stylesheet" href="{{ asset("backend/css/bootstrap.min.css") }}">');  // Optional: Link to your CSS
    newWin.document.write('</head><body>');
    newWin.document.write(divToPrint.outerHTML);
    newWin.document.write('</body></html>');
    newWin.document.close();
    newWin.print();

}

</script>
@endsection
