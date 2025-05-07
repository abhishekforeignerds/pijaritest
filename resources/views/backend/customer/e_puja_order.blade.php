@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">View Customer</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            @include('backend.customer.order_nav')
                        </div>
                    </div>
                    <form method="GET" id="order_form" action="{{ route('customer_e_puja',$user->id) }}">
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-12">
                                <div class="top_search justify-content-start">
                                    <input type="text" class="form-control" name="daterange" id="daterange"
                                        placeholder="Date Filter" value="{{ request('daterange') }}" />

                                    <input type="text" class="form-control" name="search" id="search"
                                        onchange="filter()" placeholder="Search..." value="{{ request('search') }}" />

                                    <select class="form-control" name="payment_status" id="payment_status">
                                        <option value="">Select Status</option>
                                        <option value="paid">Paid</option>
                                        <option value="unpaid">Unpaid</option>
                                    </select>

                                    <select id='puja' name="puja" class="form-control">
                                        <option value=''>Select Puja</option>
                                        @foreach (App\Models\Product::where('product_type', 'one_day')->where('status', 1)->get() as $puja)
                                            <option value='{{ $puja->id }}'
                                                @if (request('puja') == $puja->id) selected @endif>{{ $puja->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button onclick="filter()" class="btn btn-custom radius-30 mt-2 mt-lg-0">Apply</button>
                                    <button type="submit" name="export" value="export"
                                        class="btn btn-custom radius-30 mt-2 mt-lg-0">Export</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">ORDER CODE</th>
                                        <th scope="col">CUSTOMER</th>
                                        <th scope="col">DATE</th>
                                        <th scope="col">PUJA DATE</th>
                                        <th scope="col">PUJA NAME</th>
                                        <th scope="col">PACKAGE</th>
                                        <th scope="col">AMOUNT</th>
                                        <th scope="col">PAYMENT</th>
                                        @if (auth()->guard('admin')->user()->canany(['order-view']))
                                            <th scope="col">ACTION</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->code }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->product->date }}</td>
                                            <td>{{ $order->product_name }}</td>
                                            <td>{{ $order->package_name }}</td>
                                            <td>₹{{ $order->grand_total }}</td>
                                            <td>
                                                @if ($order->payment_status == 'paid')
                                                    <p class="text-success">Paid</p>
                                                @else
                                                    <p class="text-danger">UnPaid</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if (auth()->guard('admin')->user()->can('order-view'))
                                                    <div class="d-flex order-actions">
                                                        <a href="{{ route('order.invoice', $order->id) }}" class=""
                                                            title="Invoice" target="_blank"><i class="fa fa-print"></i></a>
                                                        <a href="{{ route('admin.one_day_order_show', $order->id) }}"
                                                            class="" title="Show"><i class="bx bxs-show"></i></a>
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
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
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
