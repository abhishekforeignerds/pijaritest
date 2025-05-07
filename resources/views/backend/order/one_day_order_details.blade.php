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
            <div class="auto-container">
                <div class="content">
                    <div class="container-fluid">
                        <div class="page-content">
                            <div class="">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="border-bottom bg-transparent card-header">
                                                <h6 class="header-title mb-0">Order Summary</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered"
                                                        style="width:100%; table-layout: fixed;">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th scope="col" style="width: 20%;">Customer Details</th>
                                                                <th scope="col" style="width: 20%;">Puja Details</th>
                                                                <th scope="col" style="width: 20%;">Amount</th>
                                                                <th scope="col" style="width: 20%;">Billing Details</th>
                                                                <th scope="col" style="width: 20%;">Order Details</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <table class="nested-table">
                                                                        <tr>
                                                                            <td><b>Name:</b>
                                                                                <p>{{ implode(',', json_decode($order->name)) }}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Phone:</b>
                                                                                <p>{{ $order->phone }}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Gotra:</b>
                                                                                <p>
                                                                                    {{ $order->gotra ? $order->gotra : 'Kashyap ' }}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        @if ($order->is_prashad == 1)
                                                                            <tr>
                                                                                <td><b>Address:</b>
                                                                                    <p>{{ json_decode($order->shipping_address)->house_no }},{{ json_decode($order->shipping_address)->area }},{{ json_decode($order->shipping_address)->landmark }},{{ json_decode($order->shipping_address)->city }},{{ json_decode($order->shipping_address)->pincode }},{{ json_decode($order->shipping_address)->state }}
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </table>
                                                                </td>

                                                                <td>
                                                                    <table class="nested-table">
                                                                        <tr>
                                                                            <td><b>Name:</b>
                                                                                <p>{{ $order->order_detail[0]->product_name ?? '--' }}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Puja Date:</b>
                                                                                <p>{{ $order->order_detail[0]->date ?? '--' }}
                                                                                    ({{ $order->order_detail[0]->time ?? '--' }})
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Location:</b>
                                                                                <p>{{ $order->order_detail[0]->location ?? '--' }}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>

                                                                <td>
                                                                    <table class="nested-table">
                                                                        <tr>
                                                                            <td><b>Total Amount :</b>
                                                                                <p>₹{{ $order->grand_total }}</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Dakshina :</b>
                                                                                <p>₹{{ $order->dakshina }}</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Prashad :</b>
                                                                                <p>₹{{ $order->prashad_price }}
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>

                                                                            <td><b>Total Paid:</b>
                                                                                <p>₹{{ $order->total_paid }}</p>
                                                                            </td>
                                                                        </tr>
                                                                        @if ($order->wallet_discount)
                                                                            <tr>
                                                                                <th scope="row">Wallet Discount :
                                                                                </th>
                                                                                <td>₹{{ $order->wallet_discount }}</td>
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
                                                                                    <p>{{ json_decode($order->payment_details)->id }}
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </table>
                                                                </td>

                                                                <td>
                                                                    <table class="nested-table">
                                                                        <tr>
                                                                            <td>
                                                                                <select class="form-select"
                                                                                    name="payment_status"
                                                                                    id="payment_status"
                                                                                    onchange="update_payment_status()"
                                                                                    @if ($order->payment_status == 'paid' || $order->payment_status == 'cancel') disabled @endif>
                                                                                    <option>Select Payment Status</option>
                                                                                    <option value="paid"
                                                                                        @if ($order->payment_status == 'paid') selected @endif>
                                                                                        Paid
                                                                                    </option>
                                                                                    <option value="unpaid"
                                                                                        @if ($order->payment_status == 'unpaid') selected @endif>
                                                                                        Unpaid
                                                                                    </option>
                                                                                    <option value="cancel"
                                                                                        @if ($order->payment_status == 'cancel') selected @endif>
                                                                                        Cancel
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
                                                                    <table
                                                                        class="table-centered border table-nowrap mb-lg-0 table">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                                <th>Product</th>
                                                                                <th>Price</th>
                                                                                <th>Inclusion</th>
                                                                                <th>Puja Info</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php $order_detail=$order; @endphp
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3"><img
                                                                                                src="{{ $order_detail->product_image }}"
                                                                                                alt=""
                                                                                                style="height: 56px;">
                                                                                        </div>
                                                                                        <div class="flex-1">
                                                                                            <h6 class="m-0">
                                                                                                {{ $order_detail->product_name }}
                                                                                            </h6>
                                                                                            <p>
                                                                                                @foreach (json_decode($order_detail->inclusion) as $inclusions)
                                                                                                    {{ App\Models\Inclusion::find($inclusions)->inclusion }},
                                                                                                @endforeach
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>₹{{ $order_detail->price }}</td>
                                                                                @if (!empty($order_detail->inclusion_price))
                                                                                    <td>
                                                                                        @foreach (json_decode($order_detail->inclusion_price) as $price)
                                                                                            +₹{{ $price }}
                                                                                        @endforeach
                                                                                    </td>
                                                                                @endif
                                                                                <td>
                                                                                    Puja Date :
                                                                                    {{ date('Y-m-d H:i:s', $order_detail->date) }}<br>
                                                                                </td>

                                                                            </tr>

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
                            </div>
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
