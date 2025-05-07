@extends('user_dashboard.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-9 col-9">
                                        <h4 class="page-title">Withdrawl Requests</h4>
                                    </div>
                                    @if(Auth::user()->status==1 && !empty(Auth::user()->user_kyc->pan) && !empty(Auth::user()->user_kyc->pan_file) && !empty(Auth::user()->user_kyc->aadhaar) && !empty(Auth::user()->user_kyc->aadhaar_front_file) && !empty(Auth::user()->user_kyc->aadhaar_back_file) && (!empty(Auth::user()->user_kyc->account_number) || !empty(Auth::user()->user_kyc->upi_id)))
                                    <div class="col-md-3 col-3">
                                        <div class="float-end">
                                        <a class="rbt-btn btn-md" href="#" onclick="show_request_modal()">Add Withdrawl </a>
                                    </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-centered mb-0">
                                    <thead>
                                        <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Request Amount</th>
                                                {{-- <th scope="col">GST Amount</th> --}}
                                                <th scope="col">TDS Amount</th>
                                                <th scope="col">GENAIL Trust Amount</th>
                                                <th scope="col">Paid Amount</th>
                                                <th scope="col">Payment Detail</th>

                                                <th scope="col">Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($withdraw_requests as $withdraw_request)
                                        <tr>
                                            <td><span>{{ $withdraw_request->created_at->format('d-M-Y h:i A') }}</span></td>
                                            <td><span>₹{{ $withdraw_request->amount }}</span></td>
                                            {{-- <td><span>₹{{ $withdraw_request->gst_amount }}</span></td> --}}
                                            <td><span>₹{{ $withdraw_request->tds_amount }}</span></td>
                                            <td><span>₹{{ $withdraw_request->gt_amount }}</span></td>
                                            <td><span>₹{{ $withdraw_request->paid_amount }}</span></td>
                                            <td>
                                                @php  $payment_details=json_decode($withdraw_request->payment_details); @endphp
                                                    @if(!empty($payment_details->id))
                                                    Payment Id: {{$payment_details->id}}<br>
                                                    Payment Status: {{$payment_details->status}}
                                                    @endif
                                                @if(!empty($payment_details->payload))

                                                    Payment Id: {{$payment_details->payload->payout->entity->id}}<br>
                                                    Payment Status:{{$payment_details->payload->payout->entity->status}}

                                                @endif
                                            </td>
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
                                <div class="d-flex justify-content-center mt-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="request_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send A Withdraw Request</h5>
                </div>
                @if (Auth::user()->balance > 500)
                  @if(!empty(Auth::user()->user_kyc->account_number) || !empty(Auth::user()->user_kyc->upi_id))
                    <form class="" action="{{route('customer.withdrawl_request_store')}}" method="post">
                        @csrf
                        <div class="modal-body gry-bg px-3 pt-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Note</label>
                                </div>
                                <div class="col-md-9">
                                   <p>*Recomended Withdrwal Timing 10:00 A.M - 8:00 P.M .Bank Transfer Time May Take 48-72hrs.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Amount <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control mb-3" name="amount" id="amount" min="500" max="{{Auth::user()->balance}}" placeholder="Amount" onchange="calculate_amount()" required>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-3">
                                    <label>GST Amount (18%)<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control mb-3" name="gst_amount" id="gst_amount"  placeholder="Amount" readonly>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-md-3">
                                    <label>TDS Amount (5%)<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control mb-3" name="tds_amount" id="tds_amount"  placeholder="Amount" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>GENAIL Trust Amount (1%)<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control mb-3" name="gt_amount" id="gt_amount"  placeholder="Amount" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Amount Paid<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control mb-3" name="paid_amount" id="paid_amount"   placeholder="Amount" readonly>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="p-5 heading-3">
                           Please Add Bank Details
                        </div>
                    </div>
                    @endif
                @else
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="p-5 heading-3">
                            You do not have enough balance to send withdrawl request
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function show_request_modal(){
            $('#request_modal').modal('show');
        }

        function calculate_amount(){
            var amount = $('#amount').val();

            // var gst_amount = (amount*18)/100;
            var tds_amount =(amount*5)/100;;
            var gt_amount = (amount*1)/100;;
            var paid_amount = amount-(tds_amount+gt_amount);

            // $('#gst_amount').val(gst_amount);
            $('#tds_amount').val(tds_amount);
            $('#gt_amount').val(gt_amount);
            $('#paid_amount').val(paid_amount);

        }
    </script>
@endsection
