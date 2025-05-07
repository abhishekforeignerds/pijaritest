@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Approve Withdrwal Request List</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <form method="GET" id="withdrawl_form" action="{{route('admin.withdrwal_request')}}">
                        <tr>
                            <td>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Date Filter"
                                        value="{{request('daterange')}}" />
                                </div>
                            </td>
                            <td>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="search" id="search" onchange="filter()" placeholder="Search..."
                                        value="{{request('search')}}" />
                                </div>
                            </td>
                            <h5 style="float:right;">Total Amount:{{$withdraw_requests->sum('amount')}}</h5>
                        </tr>
                        </form>
                    </table>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Payment Details</th>
                                    <th scope="col">Request Amount</th>
                                    <th scope="col">Check Status</th>
                                    <th scope="col">TDS Amount</th>
                                    <th scope="col">GENAIL Trust Amount</th>
                                    <th scope="col">Paid Amount</th>
                                    <th scope="col">Message</th>


                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($withdraw_requests as $withdraw_request)
                                        <tr>
                                            <td><span>{{ $withdraw_request->created_at->format('d-M-Y h:i A') }}</span></td>
                                            <td><span>{{$withdraw_request->user->name}}<br>{{$withdraw_request->user->phone}}<br>{{$withdraw_request->user->email}}<br>{{$withdraw_request->user->referral_code}}</span></td>
                                            <td>
                                                @php $payment_status=''; @endphp
                                                @php $payment_details=json_decode($withdraw_request->payment_details); @endphp
                                                @if(!empty($payment_details->fund_account->account_type))
                                                    Payment Id:{{$payment_details->id}}<br>
                                                    Payment Status: {{$payment_details->status}}<br>
                                                    @php $payment_status=$payment_details->status; @endphp
                                                    Account Type:{{$payment_details->fund_account->account_type}}<br>
                                                    @if($payment_details->fund_account->account_type=='vpa')
                                                        Username:{{$payment_details->fund_account->vpa->username}}<br>
                                                        Handle:{{$payment_details->fund_account->vpa->handle}}<br>
                                                        Address:{{$payment_details->fund_account->vpa->address}}
                                                    @endif
                                                    @if($payment_details->fund_account->account_type=='bank_account')
                                                        Bank Name:{{$payment_details->fund_account->bank_account->bank_name}}<br>
                                                        Name:{{$payment_details->fund_account->bank_account->name}}<br>
                                                        Account Number:{{$payment_details->fund_account->bank_account->account_number}}<br>
                                                        IFSC:{{$payment_details->fund_account->bank_account->ifsc}}<br>
                                                    @endif
                                                @endif
                                                @if(!empty($payment_details->payload))

                                                Payment Id: {{$payment_details->payload->payout->entity->id}}<br>
                                                Payment Status:{{$payment_details->payload->payout->entity->status}}

                                                @php $payment_status=$payment_details->payload->payout->entity->status; @endphp

                                                @endif

                                                @if(!empty($payment_details->status))

                                                Payment Id: {{$payment_details->id}}<br>
                                                Payment Status:{{$payment_details->status}}

                                                @php $payment_status=$payment_details->status; @endphp

                                                @endif
                                            </td>
                                            <td><span>₹{{ $withdraw_request->amount }}</span></td>
                                            <td>@if($withdraw_request->status==0)
                                                  <a href="{{ route('admin.check_status_for_payment',$withdraw_request->payment_id) }}"
                                                    class="btn btn-primary radius-30 mt-2 mt-lg-0">Check Status</a>
                                                @else
                                                    @if(!empty($withdraw_request->payment_id) && ($payment_status=='processing'))
                                                    <a href="{{ route('admin.check_status_for_payment',$withdraw_request->payment_id) }}"
                                                    class="btn btn-primary radius-30 mt-2 mt-lg-0">Check Status</a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td><span>₹{{ $withdraw_request->tds_amount }}</span></td>
                                            <td><span>₹{{ $withdraw_request->gt_amount }}</span></td>
                                            <td><span>₹{{ $withdraw_request->paid_amount }}</span></td>
                                            <td><span>{{ $withdraw_request->message }}</span></td>

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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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

        function filter(){
            $('#withdrawl_form').submit();
        }
</script>
    <script>
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('admin_service.update_featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }

        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('admin_service.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {

                } else {

                }
            });
        }

    </script>
@endsection

