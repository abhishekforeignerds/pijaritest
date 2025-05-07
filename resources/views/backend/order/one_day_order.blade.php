@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h6 class="card_title">E-Puja Order List &nbsp;</h6>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-end">
                                <h6 class="card_title">Total Amount :
                                    <span>
                                        @if (count($orders) > 0)
                                            ₹{{ $orders->sum('grand_total') }}
                                        @endif
                                    </span>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" id="order_form" action="{{ route('admin.one_day_orders') }}">
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-12">
                                <div class="top_search">
                                    <div class="">
                                        <label for="daterange">Date Filter</label>
                                        <input type="text" class="form-control" name="daterange" id="daterange"
                                            placeholder="Date Filter" value="{{ request('daterange') }}" />
                                    </div>
                                    <div class="">
                                        <label for="search">search</label>
                                        <input type="text" class="form-control" name="search" id="search"
                                            onchange="filter()" placeholder="Search..." value="{{ request('search') }}" />
                                    </div>
                                    <div class="">
                                        <label for="payment_status">status</label>
                                        <select class="form-control" name="payment_status" id="payment_status">
                                            <option value="">Select Status</option>
                                            <option value="paid">Paid</option>
                                            <option value="unpaid">Unpaid</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label for="puja">Select puja</label>
                                        <select id='puja' name="puja" class="form-control">
                                            <option value=''>Select Puja</option>
                                            @foreach (App\Models\Product::where('product_type', 'one_day')->where('status', 1)->get() as $puja)
                                                <option value='{{ $puja->id }}'
                                                    @if (request('puja') == $puja->id) selected @endif>{{ $puja->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <button onclick="filter()"
                                            class="btn btn-custom radius-30 mt-2 mt-lg-0">Apply</button>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" name="export" value="export"
                                            class="btn btn-custom radius-30 mt-2 mt-lg-0">Export</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="table-responsive">
                            <table id="example" class="table align-middle mb-0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No.</th>
                                        <th scope="col">Billing Details </th>
                                        <th scope="col">Puja Details </th>
                                        <th scope="col">Customer Details</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Order Details</th>
                                        @if (auth()->guard('admin')->user()->canany(['order-view']))
                                            <th scope="col">ACTION</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @forelse ($orders as $key=>$order)
                                        <tr>
                                            <td> {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                            <td>
                                                <p class="mb-0"><b>Order ID :</b>{{ $order->code }}</p>
                                                <p class="mb-0"><b>Booking Date :</b>{{ $order->created_at }}
                                            </td>
                                            <td>
                                                <p class="mb-0"><b>Name:</b>{{ $order->product_name }}</p>
                                                <p class="mb-0"><b>Package:</b>{{ $order->package_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0"><b>Name :</b>{{ $order->user->name }}</p>
                                                <p class="mb-0"><b>Phone :</b>{{ $order->user->phone }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0"><b>Total :</b>₹{{ $order->grand_total }}</p>
                                                <p class="mb-0"><b>Dakshina :</b>₹{{ $order->dakshina ?: 0 }}</p>
                                                <p class="mb-0"><b>Prashad :</b>₹{{ $order->prashad_price ?: 0 }}</p>
                                            </td>
                                            <td>
                                                <b>Payment Status:</b>
                                                @if ($order->payment_status == 'paid')
                                                    <p class="text-success mb-0">Paid</p>
                                                @else
                                                    <p class="text-danger mb-0">UnPaid</p>
                                                @endif
                                                <p class="mb-0"><b>Puja date:</b>{{ $order->product->date }}</p>
                                            </td>
                                            <td>
                                                @if (auth()->guard('admin')->user()->can('order-view'))
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ route('one_day_order_invoice.invoice', $order->id) }}"
                                                            class="" title="Invoice" target="_blank"><i
                                                                class="fa fa-print"></i></a>
                                                        <a href="{{ route('admin.one_day_order_show', $order->id) }}"
                                                            class="ms-1" title="Show"><i class="bx bxs-show"></i></a>
                                                    </div>
                                                @endif
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
                    @if (count($orders) > 0)
                        {{ $orders->links() }}
                    @endif
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
        $('input[name="daterange"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $(document).ready(function() {
            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
                filter();

            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                filter();

            });
        });

        function filter() {
            $('#order_form').submit();
        }
    </script>
@endsection
