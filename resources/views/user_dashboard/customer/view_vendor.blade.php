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
                                    <h4 class="page-title">View Vendor</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                                <div class="row">
                                    <div class="col-md-4 mb-3 ">
                                        <label for="Name" class="form-label">Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="Name" placeholder="Name"
                                            name="name" value="{{ $vendor->name }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="Email" class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="Email" placeholder="Email"
                                            name="email" value="{{ $vendor->email }}" readonly>
                                            <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="pincode" class="form-label">Pincode</label>
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
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" placeholder="City"
                                            name="city" value="{{ $vendor->city }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" class="form-control" id="state" placeholder="State"
                                            name="state" value="{{ $vendor->state }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="Address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="Address" placeholder="Address"
                                            name="address" value="{{ $vendor->address }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="FirmName" class="form-label">Firm Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="FirmName" placeholder="Firm Name"
                                            name="firm_name" value="{{ $vendor->firm_name }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="BankName" class="form-label">Bank Name</label>
                                        <input type="text" class="form-control" id="BankName" placeholder="Bank Name"
                                            name="bank_name" value="{{ $vendor->bank_name }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="BranchName" class="form-label">Branch Name</label>
                                        <input type="text" class="form-control" id="BranchName" placeholder="Branch Name"
                                            name="branch_name" value="{{ $vendor->branch_name }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="AccountHolderName" class="form-label">Bank Account Number</label>
                                        <input type="number" class="form-control" id="account_number"
                                            placeholder="Bank Account Number" name="account_number"
                                            value="{{ $vendor->account_number }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="AccountHolderName" class="form-label">Account Holder
                                            Name</label>
                                        <input type="text" class="form-control" id="AccountHolderName"
                                            placeholder="Account Holder Name" name="account_holder_name"
                                            value="{{ $vendor->account_holder_name }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="IFSCcode" class="form-label">IFSC Code</label>
                                        <input type="text" class="form-control" id="IFSCcode"
                                            placeholder="IFSC Code" name="ifsc_code" value="{{ $vendor->ifsc_code }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="Logo" class="form-label">Logo</label>
                                        <input type="file" class="form-control" id="Logo" placeholder="Logo"
                                            name="logo" value="{{ $vendor->logo }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="GSTIN" class="form-label">GSTIN</label>
                                        <input type="text" class="form-control" id="GSTIN" placeholder="GSTIN"
                                            name="gstin" value="{{ $vendor->gstin }}">
                                    </div>
                                    <div class="col-md-4 mb-3 ">
                                        <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="phone"
                                            placeholder="Enter Phone" name="phone"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            onkeypress="if(this.value.length==10) return false;" maxlength="10"
                                            value="{{ $vendor->phone }}" readonly>
                                            <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                    </div>
                                    {{-- <div class="col-md-6 mb-2">
                                        <label for="multiple-select-clear-field" class="form-label">Business
                                            Category</label>
                                        <select class="form-select" id="multiple-select-clear-field"
                                            data-placeholder="Choose anything" onchange="comission_table_show()" multiple>
                                            @foreach (App\Models\BusinessCategory::all() as $business_catory)
                                                <option value="{{ $business_catory->id }}"
                                                    @if (in_array($business_catory->id, json_decode($vendor->business_category))) {{ 'selected' }} @endif>
                                                    {{ $business_catory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-xl-6 mx-auto mt-4" id="comission_table">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
        comission_table_show()
    });
</script>
<script>
    $(function() {
        $("form[name='vendor_regiter']").validate({

            rules: {

                name: "required",
                email: {
                    required: true,
                    email: true,
                },
                phone: "required",
                password: {
                    minlength: 6
                }
            },

            messages: {
                name: "Please enter your Name",
                email: {
                    required: "Please enter the email address  ",
                    email: "Please enter a valid email address"
                },
                phone: "Please enter phone",
                password: {
                    required: "Please provide password",
                    minlength: "Your password must be at least 5 characters long"
                },

            },

            submitHandler: function(form) {
                form.submit();
            }
        });
    });

    function comission_table_show() {
        var business_category = $('#multiple-select-clear-field').val();
        var vendor_id = "{{ $vendor->id }}";
        $.get('{{ route('vendor_comission_percentage') }}', {
            _token: '{{ csrf_token() }}',
            business_category: business_category,
            vendor_id: vendor_id
        }, function(data) {
            $('#comission_table').empty();
            $('#comission_table').html(data);
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('backend/plugins/select2/js/select2-custom.js') }}"></script>

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
