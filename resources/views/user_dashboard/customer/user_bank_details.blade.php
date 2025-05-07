@extends('user_dashboard.layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <h4 class="page-title">User Bank Details</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <h5 class="mb-3 text-uppercase bg-light p-2">Bank Account Information</h5>
                            <hr>
                            <form action="{{ route('customer.bank_info_update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="holder_name" class="form-label">Account Holder Name <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="holder_name" name="holder_name"
                                            value="{{ Auth::user()->user_kyc->account_holder_name }}"
                                            class="form-control bank_details" placeholder="Holder Name..." >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ifsc_code" class="form-label">IFSC Code <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="ifsc_code" name="ifsc_code"
                                            value="{{ Auth::user()->user_kyc->ifsc_code }}"class="form-control bank_details"
                                            placeholder="IFSC Code..." >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="account_number" class="form-label">Account Number <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="account_number" name="account_number"
                                            value="{{ Auth::user()->user_kyc->account_number }}"
                                            class="form-control bank_details" placeholder="Account Number...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="bank_name" class="form-label">Bank Name <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="bank_name" name="bank_name"
                                            value="{{ Auth::user()->user_kyc->bank_name }}"
                                            class="form-control bank_details" placeholder="Bank Name..." >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="branch_name" class="form-label">Bank Branch Name <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="branch_name" name="branch_name"
                                            value="{{ Auth::user()->user_kyc->branch_name }}"
                                            class="form-control bank_details" placeholder="Bank Branch Name..." reuired>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="upi_id" class="form-label">Nominee Name <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="nominee_name" name="nominee_name"
                                            class="form-control bank_details"
                                            value="{{ Auth::user()->user_kyc->nominee_name }}" placeholder="Nominee Name..."
                                            >
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="upi_id" class="form-label">Nominee Relation <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="nominee_relation" name="nominee_relation"
                                            class="form-control bank_details"
                                            value="{{ Auth::user()->user_kyc->nominee_relation }}"
                                            placeholder="Nominee Relation..." >
                                    </div>
                                    <div class="col-md-6 mb-3">

                                    </div>
                                    <hr>
                                    <div class="col-md-6 mb-3">
                                        <label for="upi_id" class="form-label">UPI ID <span
                                                class="text-danger"></span></label>
                                        <input type="text" id="upi_id" name="upi_id" class="form-control upi_details"
                                            value="{{ Auth::user()->user_kyc->upi_id }}" placeholder="UPI ID...">
                                    </div>
                                </div>
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(".bank_details").change(function() {
        $(".bank_details").prop('required',true);
        $(".upi_details").prop('required',false);
    });

    $(".upi_details").keyup(function() {
        $(".bank_details").prop('required',false);
        $(".upi_details").prop('required',true);
    });

</script>
@endsection
