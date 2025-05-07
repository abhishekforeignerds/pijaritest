@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-3">
                            <h6 class="mb-0">View Customer</h6>
                        </div>
                        <div class="col-lg-9">
                            @include('backend.customer.order_nav')
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-info">
                                <a href="{{ route('admin_product.index') }}">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Puja</p>
                                                <h6 class="my-1 text-info">{{ App\Models\Product::get()->count() }}</h6>
                                            </div>
                                            <div
                                                class="widgets-icons-2 wid-size rounded-circle bg-gradient-blues text-white ms-auto">
                                                <i class='bx bxs-cart'></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-danger">
                                <a href="{{ route('admin.orders') }}">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Orders</p>
                                                <h6 class="my-1 text-danger">{{ App\Models\Order::get()->count() }}</h6>
                                            </div>
                                            <div
                                                class="widgets-icons-2 wid-size rounded-circle bg-gradient-burning text-white ms-auto">
                                                <i class='bx bxs-wallet'></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-danger">
                                <a href="{{ route('enquiry.index') }}">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Enquiries</p>
                                                <h6 class="my-1 text-danger">{{ App\Models\Enquiry::get()->count() }}</h6>
                                            </div>
                                            <div
                                                class="widgets-icons-2 wid-size rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                <i class='bx bx-message-dots'></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-warning">
                                <a href="{{ route('customer_list') }}">
                                    <div class="card-body p-2">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Customers</p>
                                                <h6 class="my-1 text-warning">{{ App\Models\User::get()->count() }}</h6>
                                            </div>
                                            <div
                                                class="widgets-icons-2 wid-size rounded-circle bg-gradient-orange text-white ms-auto">
                                                <i class='bx bxs-group'></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <form method="GET" id="order_form" action="{{ route('customer_view', $user->id) }}">
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-12">
                                <div class="top_search">
                                    <input type="text" class="form-control" name="daterange" id="daterange"
                                        placeholder="Date Filter" value="{{ request('daterange') }}" />
                                    <input type="text" class="form-control" name="search" id="search"
                                        onchange="filter()" placeholder="Search..." value="{{ request('search') }}" />
                                    <select class="form-control" name="payment_status" id="payment_status">
                                        <option value="">Select Status</option>
                                        <option value="paid">Paid</option>
                                        <option value="unpaid">Unpaid</option>
                                    </select>
                                    <select id='searchPoojaType' name="puja_type" class="form-control">
                                        <option value=''>Select Puja Type</option>
                                        <option value="temple">Temple</option>
                                        <option value="all">All</option>
                                    </select>
                                    <select id='searchLocationType' name="location_type" class="form-control">
                                        <option value=''>Select Location Type</option>
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                        <option value="both">Both</option>
                                    </select>
                                    <select id='pujari_status' name="pujari_status" class="form-control">
                                        <option value=''>Select Pujari Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="accepted">Accepted</option>
                                        <option value="completed">Completed</option>
                                        <option value="decline">Decline</option>
                                    </select>
                                    <button onclick="filter()" class="btn btn-custom radius-30 mt-2 mt-lg-0">Apply</button>
                                    <button type="submit" name="export" value="export"
                                        class="btn btn-custom radius-30 mt-2 mt-lg-0">Export</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">ORDER CODE</th>
                                    <th scope="col">POOJA NAME</th>
                                    <th scope="col">POOJA DATE</th>
                                    <th scope="col">POOJA TYPE</th>
                                    <th scope="col">POOJA LOCATION</th>
                                    <th scope="col">AMOUNT</th>
                                    <th scope="col">PUJARI</th>
                                    <th scope="col">STATUS</th>

                                    <th scope="col">DATE</th>
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
                                        <td>{{ $order->order_detail[0]->product_name }}</td>
                                        <td>{{ $order->order_detail[0]->date }}</td>
                                        <td>
                                            @if ($order->order_detail[0]->product->product_type == 'temple')
                                                {{ 'Terth Puja' }}
                                            @else
                                                All Puja
                                            @endif
                                        </td>
                                        <td>{{ $order->order_detail[0]->location }}</td>
                                        <td>Total : ₹{{ $order->grand_total }}<br>
                                             Paid : ₹{{ $order->total_paid }}
                                        </td>
                                        <td>
                                            {{optional($order->order_detail[0]->pujari)->name}}
                                        </td>
                                        <td>
                                            @if (!empty($order->order_detail[0]->pujari_status))
                                                {{ $order->order_detail[0]->pujari_status }}
                                            @else
                                                Pending
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at }}</td>
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
                                                    <a href="{{ route('admin.order_show', $order->id) }}" class=""
                                                        title="Show"><i class="bx bxs-show"></i></a>

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
