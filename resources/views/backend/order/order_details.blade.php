@extends('backend.layouts.app')
@section('content')
    <style>
        .table th,
        .table td {
            padding: 10px;
            vertical-align: top;
            text-align: left;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table tbody tr td table {
            width: 100%;
        }

        .table tbody tr td table td {
            padding: 5px;
        }

        .table tbody tr td select {
            width: 100%;
            padding: 5px;
        }

        .table th,
        .table td {
            padding: 10px;
            vertical-align: top;
            text-align: left;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .nested-table {
            width: 100%;
        }

        .nested-table td {
            padding: 5px;
        }

        .nested-table p {
            margin: 5px 0;
        }
    </style>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="border-bottom bg-transparent card-header">
                            <h6 class="header-title mb-0">Order Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col" style="width: 20%;">Customer Details</th>
                                            <th scope="col" style="width: 20%;">Puja Details</th>
                                            <th scope="col" style="width: 20%;">Billing Details</th>
                                            <th scope="col" style="width: 20%;">Amount</th>
                                            <th scope="col" style="width: 20%;">Order Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="nested-table">
                                                    <tr>
                                                        <td><b>Name:</b>
                                                            <p>{{ json_decode($order->shipping_address)->name }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Phone:</b>
                                                            <p>{{ json_decode($order->shipping_address)->phone }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Address:</b>
                                                            <p>
                                                                {{ json_decode($order->shipping_address)->address }},<br>
                                                                {{ json_decode($order->shipping_address)->city }},<br>
                                                                {{ json_decode($order->shipping_address)->pincode }},<br>
                                                                {{ json_decode($order->shipping_address)->state }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    @if (!empty(json_decode($order->shipping_address)->email))
                                                        <tr>
                                                            <td><b>Email:</b>
                                                                <p>{{ json_decode($order->shipping_address)->email }}</p>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </td>

                                            <td>
                                                <table class="nested-table">
                                                    <tr>
                                                        <td><b>Name:</b>
                                                            <p>{{ $order->order_detail[0]->product_name ?? '--' }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Puja Date:</b>
                                                            <p>{{ $order->order_detail[0]->date ?? '--' }}
                                                                ({{ $order->order_detail[0]->time ?? '--' }})</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Location:</b>
                                                            <p>{{ $order->order_detail[0]->location ?? '--' }}</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td>
                                                <table class="nested-table">
                                                    <tr>
                                                        <td><b>Total Amount:</b>
                                                            <p>₹{{ $order->grand_total }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Total Paid:</b>
                                                            <p>₹{{ $order->total_paid }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Total Due:</b>
                                                            <p>₹{{ $order->grand_total - $order->total_paid }}</p>
                                                        </td>
                                                    </tr>
                                                    @if ($order->wallet_discount)
                                                        <tr>
                                                            <td><b>Wallet Discount:</b>
                                                                <p>₹{{ $order->wallet_discount }}</p>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </td>

                                            <td>
                                                <table class="nested-table">
                                                    <tr>
                                                        <td><b>Order ID:</b>
                                                            <p>#{{ $order->code }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Booking Date:</b>
                                                            <p>{{ $order->created_at }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Payment Type:</b>
                                                            <p>{{ $order->payment_type }}</p>
                                                        </td>
                                                    </tr>
                                                    @if (!empty($order->payment_details))
                                                        <tr>
                                                            <td><b>Payment Details:</b>
                                                                <p>{{ json_decode($order->payment_details)->id }}</p>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </td>

                                            <td>
                                                <table class="nested-table">
                                                    <tr>
                                                        <td>
                                                            <select class="form-select" name="payment_status"
                                                                id="payment_status" onchange="update_payment_status()"
                                                                @if ($order->payment_status == 'paid' || $order->payment_status == 'cancel') disabled @endif>
                                                                <option>Select Payment Status</option>
                                                                <option value="paid"
                                                                    @if ($order->payment_status == 'paid') selected @endif>Paid
                                                                </option>
                                                                <option value="unpaid"
                                                                    @if ($order->payment_status == 'unpaid') selected @endif>Unpaid
                                                                </option>
                                                                <option value="cancel"
                                                                    @if ($order->payment_status == 'cancel') selected @endif>Cancel
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Status:</b>
                                                            <p>{{ $order->order_detail[0]->pujari_status ?? 'Pending' }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table-centered border table-nowrap mb-lg-0 table">
                                                    <thead class="bg-light">
                                                        <tr>

                                                            <th>Product</th>
                                                            <th>Package Name</th>
                                                            <th>Price</th>
                                                            <th>Inclusion</th>
                                                            <th>Puja Info</th>
                                                            <th>Assign Pujari</th>
                                                            <th>Pujari Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->order_detail as $order_detail)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-3"><img
                                                                                src="{{ $order_detail->product_image }}"
                                                                                alt="" style="height: 56px;">
                                                                        </div>
                                                                        <div class="flex-1">
                                                                            <h6 class="m-0">
                                                                                {{ $order_detail->product_name }}</h6>
                                                                            <p>
                                                                                @foreach (json_decode($order_detail->inclusion) as $inclusions)
                                                                                    {{ App\Models\Inclusion::find($inclusions)->inclusion }},
                                                                                @endforeach
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $order_detail->package_name }}</td>
                                                                <td>₹{{ $order_detail->price }}</td>

                                                                @if (!empty($order_detail->inclusion_price))
                                                                    <td>
                                                                        @foreach (json_decode($order_detail->inclusion_price) as $price)
                                                                            +₹{{ $price }}
                                                                        @endforeach
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    Puja Date : {{ $order_detail->date }}<br>
                                                                    Puja Time : {{ $order_detail->time }}<br>
                                                                    Location : {{ $order_detail->location }}<br>
                                                                    City : {{ $order_detail->city }}<br>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        if ($order_detail->location == 'home') {
                                                                            $pujaries = [];
                                                                            if (
                                                                                $order_detail->product->product_type ==
                                                                                'all'
                                                                            ) {
                                                                                $city = App\Models\ServiceCity::where(
                                                                                    'city',
                                                                                    $order_detail->city,
                                                                                )->first();
                                                                                $pujaries = App\Models\Pujari::wherejsonContains(
                                                                                    'city',
                                                                                    '' . $city->id,
                                                                                )->get();
                                                                            }
                                                                            if (
                                                                                $order_detail->product->product_type ==
                                                                                'temple'
                                                                            ) {
                                                                                $city = App\Models\TerthPujaCity::where(
                                                                                    'city',
                                                                                    $order_detail->city,
                                                                                )->first();
                                                                                $pujaries = App\Models\Pujari::wherejsonContains(
                                                                                    'terth_city',
                                                                                    '' . $city->id,
                                                                                )->get();
                                                                            }
                                                                        }
                                                                        if ($order_detail->location == 'online') {
                                                                            $pujaries = App\Models\Pujari::where(
                                                                                'is_online',
                                                                                1,
                                                                            )->get();
                                                                        }

                                                                    @endphp
                                                                    <select class="form-select" aria-label="Pujari Ji"
                                                                        name="pujari_ji"
                                                                        id="pujari_ji_{{ $order_detail->id }}"
                                                                        onchange="update_pujari_ji('{{ $order_detail->id }}')">
                                                                        <option>Select Pujari Ji</option>
                                                                        @foreach ($pujaries as $pujari)
                                                                            <option value="{{ $pujari->id }}"
                                                                                @if ($order_detail->pujari_id == $pujari->id) selected @endif>
                                                                                {{ $pujari->name }}</option>
                                                                        @endforeach
                                                                        @foreach (App\Models\Pujari::where('id', 1001)->get() as $pujaries)
                                                                            <option value="{{ $pujaries->id }}"
                                                                                @if ($order_detail->pujari_id == $pujaries->id) selected @endif>
                                                                                {{ $pujaries->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    @if (!empty($order_detail->pujari_status))
                                                                        {{ $order_detail->pujari_status }}
                                                                    @else
                                                                        Pending
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-lg-4">
                </div>
                <div class="col-lg-4">
                    <div>
                        {{-- <div class="p-2 mb-lg-0 card">
                                <div class="text-center">
                                    <div class="my-2"><i class="mdi mdi-truck-fast h1 text-muted"></i></div>
                                    <div class="mt-2 pt-1">
                                        <p class="mb-0"><span class="fw-semibold">Payment Mode :</span>
                                            {{ $order->payment_type }}</p>
                                        <p class="mb-0"><span class="fw-semibold">Payment Status :</span>
                                            {{ $order->payment_status }}</p>
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--end page wrapper -->
    <!-- The Modal -->
    <div class="modal" id="amount_model">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="overflow: scroll;">
                <div class="modal-body" id="amount_model_data">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function update_pujari_ji(id) {

            var pujari_ji_id = $('#pujari_ji_' + id).val();

            if (pujari_ji_id) {


                $.post('{{ route('pujari_model') }}', {
                    _token: '{{ csrf_token() }}',
                    order_detail_id: id,
                    pujari_ji_id: pujari_ji_id,
                }, function(data) {
                    $('#amount_model_data').html(data);
                    $('#amount_model').modal('show');
                });





            } else {
                alert('Please Select Pujari Ji');
            }
        }

        function update_payment_status() {
            var status = $('#payment_status').val();


            $.post('{{ route('order_payment_status_update') }}', {
                _token: '{{ csrf_token() }}',
                order_id: '{{ $order->id }}',
                status: status
            }, function(data) {
                alert('Status Updated Sucessfully');
            });

        }

        function pujari_comission(pujari_ji_id, order_detail_id) {

            var pujari_comission = $('#comission').val();
            $.post('{{ route('status.pujariji_update') }}', {
                _token: '{{ csrf_token() }}',
                id: order_detail_id,
                pujari_id: pujari_ji_id,
                pujari_comission: pujari_comission,
            }, function(data) {
                alert('Status Updated Sucessfully');
                $('#amount_model').modal('hide');

            });

        }

        function company_amount() {
            var comission = $('#comission').val();
            var grand_total = "{{ $order->grand_total }}";
            $('#company_amount').val(grand_total - comission);
        }
    </script>
@endsection
