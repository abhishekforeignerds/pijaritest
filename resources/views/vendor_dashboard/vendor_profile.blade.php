@extends('vendor_dashboard.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    @php $vendor=Auth::guard('vendor')->user(); @endphp
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{asset('frontend/vendor/'.$vendor->logo)}}" alt="Vendor"
                                            class="rounded-circle p-1 bg-primary" width="110">
                                        <div class="mt-3">
                                            <h4>{{ $vendor->name }}</h4>
                                            <p class="text-secondary mb-1">{{ $vendor->email }}</p>
                                            <p class="text-muted font-size-sm">{{ $vendor->phone }}</p>
                                            <p class="text-muted font-size-sm">ID:{{ $vendor->vendor_code }}</p>
                                            @if (($vendor->status != 1) && (count(json_decode($vendor->business_category)) > 0) )
                                                <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#exampleVerticallycenteredModal">Pay Registration
                                                    Fee</a>
                                            @endif
                                            @if($vendor->status==1)
                                                Registration Fees Paid
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card radius-10">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0">Update Profile</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-body">
                                        <form class="row g-3" id="vendor_regiter" name="vendor_regiter" method="post"
                                            action="{{ route('vendor.profile_update') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-4">
                                                <label for="Name" class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="Name" placeholder="Name"
                                                    name="name" value="{{ $vendor->name }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="Email"
                                                    placeholder="Email" name="email" value="{{ $vendor->email }}"
                                                   required readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="inputChoosePassword" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0" id="password"
                                                        name="password" placeholder="Enter Password">
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 ">
                                                <label for="validationCustom01" class="form-label">Pincode *</label>
                                                <select class="form-control" id="pincode_select" name="pincode"
                                                    data-placeholder="Please Select Pincodes..." onchange="get_pincode()" required>
                                                    <option value="">Select Pincode</option>
                                                    @if (!empty($vendor->pincode))
                                                        <option value="{{ $vendor->pincode }}" selected>
                                                            {{ $vendor->pincode }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3 ">
                                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="city" placeholder="City"
                                                    name="city" value="{{ $vendor->city }}" readonly required>
                                            </div>
                                            <div class="col-md-4 mb-3 ">
                                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="state"
                                                    placeholder="State" name="state" value="{{ $vendor->state }}"
                                                    readonly required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Address" class="form-label">Address <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="Address"
                                                    placeholder="Address" name="address" value="{{ $vendor->address }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="FirmName" class="form-label">Firm Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="FirmName"
                                                    placeholder="Firm Name" name="firm_name"
                                                    value="{{ $vendor->firm_name }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="BankName" class="form-label">Bank Name</label>
                                                <input type="text" class="form-control" id="BankName"
                                                    placeholder="Bank Name" name="bank_name"
                                                    value="{{ $vendor->bank_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="BranchName" class="form-label">Branch Name</label>
                                                <input type="text" class="form-control" id="BranchName"
                                                    placeholder="Branch Name" name="branch_name"
                                                    value="{{ $vendor->branch_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="AccountHolderName" class="form-label">Bank Account
                                                    Number</label>
                                                <input type="number" class="form-control" id="account_number"
                                                    placeholder="Bank Account Number" name="account_number"
                                                    value="{{ $vendor->account_number }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="AccountHolderName" class="form-label">Account Holder
                                                    Name</label>
                                                <input type="text" class="form-control" id="AccountHolderName"
                                                    placeholder="Account Holder Name" name="account_holder_name"
                                                    value="{{ $vendor->account_holder_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="IFSCcode" class="form-label">IFSC Code</label>
                                                <input type="text" class="form-control" id="IFSCcode"
                                                    placeholder="IFSC Code" name="ifsc_code"
                                                    value="{{ $vendor->ifsc_code }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Logo" class="form-label">Logo</label>
                                                <input type="file" class="form-control" id="Logo"
                                                    placeholder="Logo" name="logo">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="GSTIN" class="form-label">GSTIN</label>
                                                <input type="text" class="form-control" id="GSTIN"
                                                    placeholder="GSTIN" name="gstin" value="{{ $vendor->gstin }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="tel" class="form-control" id="phone"
                                                    placeholder="Enter Phone" name="phone"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10"
                                                    value="{{ $vendor->phone }}" readonly>
                                            </div>
                                            <div class="col-12">
                                                <div>
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
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


    <!--Start Modal -->
    <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registration Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(env('APP_ENV')=='local')
                        <form class="row g-3" id="vendor_regiter_fees" name="vendor_regiter_fees" method="post"
                            action="{{ route('vendor.pay_registration_fee') }}" enctype="multipart/form-data">
                            <input type="hidden" name="payment_details" value="offline" />
                        @else
                        <form class="row g-3" id="vendor_regiter_fees" name="vendor_regiter_fees" method="post"
                        action="{{ route('vendor.pay_registration_fee_phonepe') }}" enctype="multipart/form-data">
                        @endif

                        @csrf
                        <input type="hidden" name="type" value="vendor_registration_fee" />
                        <div class="col-md-12">
                            <label for="registraion_fee" class="form-label">Registration Fees</label>
                            <input type="number" class="form-control" id="registraion_fee"
                                placeholder="Registration Fees" name="registration_fee" value="500" readonly>
                        </div>
                        <div class="col-md-12">
                            <label for="topup_category" class="form-label">Topup Category</label>
                            <input type="number" class="form-control" id="topup_category" placeholder="Topup Category"
                                name="topup_category" min="500" value="500" required>
                        </div>
                        <hr>
                        <div class="text-center mt-0">
                            <button type="submit" class="btn btn-primary">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Modal -->
@endsection
@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
        $(document).on('keypress', '.select2-search__field', function() {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $('#pincode_select').select2({
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: '{{route('admin_pincode.list')}}',
                dataType: 'json',
                data: function(params) {
                    return {
                        key: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true

            }
        });
        function get_pincode(){
           var pincode = $('#pincode_select').val();
           $.get('{{ route('admin.get_pincode') }}', {
                _token: '{{ csrf_token() }}',
                pincode: pincode
            }, function(data) {
                console.log(data);
                $('#city').val(data.city);
                $('#state').val(data.state);
            });
        }
</script>
@endsection
