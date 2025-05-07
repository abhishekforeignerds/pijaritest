@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Order List &nbsp;</h6>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <form method="GET" id="order_form" action="{{ route('customer_oneday_order',$id) }}">
                            <tr>
                                <td>

                                        <input type="text" class="form-control" name="daterange" id="daterange"
                                            placeholder="Date Filter" value="{{ request('daterange') }}" />

                                </td>
                                <td>

                                        <input type="text" class="form-control" name="search" id="search"
                                            onchange="filter()" placeholder="Search..."
                                            value="{{ request('search') }}" />

                                </td>
                                <td>

                                        <select class="form-control" name="payment_status"
                                                id="payment_status">
                                                <option value="">Select Status</option>
                                                <option value="paid">Paid</option>
                                                <option value="unpaid">Unpaid</option>
                                            </select>

                                </td>
                                <td>


                                </td>
                                <td>



                                </td>

                                <td>
                                    <select id='pujari_status' name="pujari_status" class="form-control">
                                        <option value=''>Select Pujari Status</option>
                                        <option value="pending" >Pending</option>
                                        <option value="accepted" >Accepted</option>
                                        <option value="completed" >Completed</option>
                                        <option value="decline"  >Decline</option>
                                    </select>

                                </td>
                                <td>

                                        <button onclick="filter()" class="btn btn-success">Apply</button>

                                </td>
                                <td>



                                </td>


                            </tr>
                        </form>
                    </table>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">ORDER CODE</th>
                                    <th scope="col">CUSTOMER</th>
                                    <th scope="col">DATE</th>

                                    <th scope="col">AMOUNT</th>
                                    <th scope="col">PAYMENT</th>
                                    @if(auth()->guard('admin')->user()->canany(['order-view']))  <th scope="col">ACTION</th> @endif
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>₹{{ $order->grand_total }}</td>
                                    <td>
                                        @if ($order->payment_status == 'paid')
                                            <p class="text-success">Paid</p>
                                        @else
                                            <p class="text-danger">UnPaid</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->guard("admin")->user()->can("order-view"))
                                        <div class="d-flex order-actions">
                                            <a href="{{route('order.invoice',$order->id)}}" class="" title="Invoice" target="_blank"><i class="fa fa-print"></i></a>
                                            <a href="{{route('admin.one_day_order_show',$order->id)}}" class="" title="Show"><i class="bx bxs-show"></i></a>
                                        </div>
                                        @endif
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
