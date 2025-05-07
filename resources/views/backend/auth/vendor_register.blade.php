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
                                        <img src="{{ asset('backend/images/logo-icon.png') }}" width="60"
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
                                                <label for="Name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="Name"
                                                    placeholder="Name" name="name">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Email" class="form-label">Email</label>
                                                <input type="text" class="form-control" id="Email"
                                                    placeholder="Email" name="email">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="inputChoosePassword" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0"
                                                        id="password" name="password" placeholder="Enter Password">
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Address" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="Address"
                                                    placeholder="Address" name="address">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="FirmName" class="form-label">Firm Name</label>
                                                <input type="text" class="form-control" id="FirmName"
                                                    placeholder="Firm Name" name="firm_name">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="BankName" class="form-label">Bank Name</label>
                                                <input type="text" class="form-control" id="BankName"
                                                    placeholder="Bank Name" name="bank_name">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="BranchName" class="form-label">Branch Name</label>
                                                <input type="text" class="form-control" id="BranchName"
                                                    placeholder="Branch Name" name="branch_name">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="AccountHolderName" class="form-label">Bank Account Number</label>
                                                <input type="number" class="form-control" id="account_number"
                                                    placeholder="Bank Account Number" name="account_number">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="AccountHolderName" class="form-label">Account Holder
                                                    Name</label>
                                                <input type="text" class="form-control" id="AccountHolderName"
                                                    placeholder="Account Holder Name" name="account_holder_name">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="IFSCcode" class="form-label">IFSC Code</label>
                                                <input type="text" class="form-control" id="IFSCcode"
                                                    placeholder="IFSC Code" name="ifsc_code">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Logo" class="form-label">Logo</label>
                                                <input type="file" class="form-control" id="Logo"
                                                    placeholder="Logo" name="logo">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="GSTIN" class="form-label">GSTIN</label>
                                                <input type="text" class="form-control" id="GSTIN"
                                                    placeholder="GSTIN" name="gstin">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="tel" class="form-control" id="phone"
                                                    placeholder="Enter Phone" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10" >
                                            </div>

                                            <div class="col-8">
                                                <div class="form-check form-switch mt-5">
                                                   <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked">
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">I
                                                        read and agree to Terms & Conditions</label>
                                                </div>
                                            </div>
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
        });
    </script>

    <!--app JS-->
    <script src="{{ asset('backend/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
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
                    form.submit();
                }
            });
        });
    </script>

</body>

</html>
