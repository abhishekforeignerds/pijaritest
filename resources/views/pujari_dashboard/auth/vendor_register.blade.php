<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('backend/images/favicon-32x32.png') }}" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/icons.css') }}" rel="stylesheet">
    <title>Genial | Admin Dashboard</title>
</head>

<body class="">
    <!--wrapper-->
    <div class="wrapper">
        <div class="d-flex align-items-center justify-content-center my-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9 mx-auto">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="p-4">
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('frontend/assets/images/logo/genial-logo.png') }}" height="60"
                                            alt="" />
                                    </div>
                                    <div class="text-center mb-4">
                                        <h5 class="">Genial Vendor</h5>
                                        <p class="mb-0">Please fill the below details to create your account</p>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" id="vendor_regiter" name="vendor_regiter" method="post" action="{{route('vendor.register')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-4">
                                                <label for="Name" class="form-label">Name<span>*</span></label>
                                                <input type="text" class="form-control" id="Name"
                                                    placeholder="Name" name="name" value="{{old('name')}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Email" class="form-label">Email<span>*</span></label>
                                                <input type="text" class="form-control" id="Email"
                                                    placeholder="Email" name="email" value="{{old('email')}}">
                                                    <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="inputChoosePassword" class="form-label">Password<span>*</span></label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control" name="password" id="password"
                                                        placeholder="Password" value="{{old('password')}}">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <a href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 ">
                                                <label for="pincode" class="form-label">Pincode<span>*</span></label>
                                                <select class="form-control" id="pincode_select" name="pincode"
                                                    data-placeholder="Please Select Pincodes..." onchange="get_pincode()" required>
                                                    <option value="">Select Pincode</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3 ">
                                                <label for="city" class="form-label">City</label>
                                                <input type="text" class="form-control" id="city" placeholder="City"
                                                    name="city" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3 ">
                                                <label for="state" class="form-label">State</label>
                                                <input type="text" class="form-control" id="state" placeholder="State"
                                                    name="state" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Address" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="Address"
                                                    placeholder="Address" name="address" value="{{old('address')}}" required>
                                                    <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="FirmName" class="form-label">Firm Name<span>*</span></label>
                                                <input type="text" class="form-control" id="FirmName"
                                                    placeholder="Firm Name" name="firm_name" value="{{old('firm_name')}}">
                                                    <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                        <strong>{{ $errors->first('firm_name') }}</strong>
                                                    </span>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <label for="BankName" class="form-label">Bank Name</label>
                                                <input type="text" class="form-control" id="BankName"
                                                    placeholder="Bank Name" name="bank_name" value="{{old('bank_name')}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="BranchName" class="form-label">Branch Name</label>
                                                <input type="text" class="form-control" id="BranchName"
                                                    placeholder="Branch Name" name="branch_name" value="{{old('branch_name')}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="AccountHolderName" class="form-label">Bank Account Number</label>
                                                <input type="number" class="form-control" id="account_number"
                                                    placeholder="Bank Account Number" name="account_number" value="{{old('account_number')}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="AccountHolderName" class="form-label">Account Holder
                                                    Name</label>
                                                <input type="text" class="form-control" id="AccountHolderName"
                                                    placeholder="Account Holder Name" name="account_holder_name" value="{{old('account_holder_name')}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="IFSCcode" class="form-label">IFSC Code</label>
                                                <input type="text" class="form-control" id="IFSCcode"
                                                    placeholder="IFSC Code" name="ifsc_code" value="{{old('ifsc_code')}}">
                                            </div> --}}
                                            <div class="col-md-4">
                                                <label for="Logo" class="form-label">Logo</label>
                                                <input type="file" class="form-control" id="Logo"
                                                    placeholder="Logo" name="logo">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="GSTIN" class="form-label">GSTIN</label>
                                                <input type="text" class="form-control" id="GSTIN"
                                                    placeholder="GSTIN" name="gstin" value="{{old('gstin')}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">Phone<span>*</span></label>
                                                <input type="tel" class="form-control" id="phone"
                                                    placeholder="Enter Phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10" value="{{old('phone')}}">
                                                    <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">OTP<span>*</span></label>
                                                <input type="tel" class="form-control" id="otp"
                                                    placeholder="Enter OTP" name="otp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==4) return false;" maxlength="4" value="{{old('otp')}}" required>
                                                    <span style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;" role="alert">
                                                        <strong>{{ $errors->first('otp') }}</strong>
                                                    </span>
                                            </div>
                                            {{-- <div class="col-8">
                                                <div class="form-check form-switch mt-5">
                                                   <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" required>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">I
                                                        read and agree to Terms & Conditions</label>
                                                </div>
                                            </div> --}}
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">Sign up</button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center ">
                                                    <p class="mb-0">Already have an account? <a href="{{route('vendor_login')}}">Sign
                                                            in here</a></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('backend/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <!--Password show & hide js -->
    <!--app JS-->
    <script src="{{ asset('backend/js/app.js') }}"></script>


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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
    var otp_value = 0;
    $("#phone").keyup(function() {
        var phone = $('#phone').val();
        if (phone.length > 9) {
            $.ajax({
                type: "POST",
                async: false,
                dataType: 'json',
                url: "{{ route('send.otp') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    phone: phone
                },
                success: function(response) {


                    if (response.status == true) {
                        alert('Otp Send Successfully !');
                        return true;
                    }
                    if (response.status == false) {
                        alert('Number Already Exits !');
                        return false;
                    }
                    if (response.status == 'Wrong') {
                        alert('Wrong Input !');
                        return false;
                    }
                }
            });
        }
    });

    $("#otp").keyup(function() {
        var check_otp = $('#otp').val();
        if (check_otp.length > 3) {
            $.ajax({
                type: "POST",
                async: false,
                dataType: 'json',
                url: "{{ route('check_otp') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    otp: check_otp
                },
                success: function(response) {
                    if (response == 1) {
                        alert('Otp Verified');
                        otp_value = 1;
                        return true;
                    } else {
                        alert('Worng Otp');
                        otp_value = 0;
                        return false;
                    }
                }
            });
        }
    });


        $(function() {
            $("form[name='vendor_regiter']").validate({

                    rules: {

                        name: "required",
                        firm_name: "required",
                        email: {
                            required: true,
                            email: true,
                        },
                        phone: "required",
                        password: {
                            required: true,
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
                    if (otp_value == 0) {
                        alert('Worng Otp');
                        return false; // Prevent form submission
                    }
                    if (otp_value == 1) {
                        return true;
                        form.submit();
                    }
                }
            });
        });

</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>
</body>

</html>
