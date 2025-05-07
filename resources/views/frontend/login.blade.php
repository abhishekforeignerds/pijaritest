@extends('frontend.layouts.app')
@section('content')
<style>
    #partitioned,
    #partitioned_sms,
    #partitioned_email {
        padding-left: 15px;
        letter-spacing: 42px;
        border: 0;
        background-image: linear-gradient(to left, black 70%, rgba(255, 255, 255, 0) 0%);
        background-position: bottom;
        background-size: 50px 1px;
        background-repeat: repeat-x;
        background-position-x: 35px;
        width: 220px;
        min-width: 220px;
    }

    #divInner {
        left: 0;
        position: sticky;
    }

    #divOuter {
        width: 190px;
        overflow: hidden;
    }

    #partitioned-error {
        margin-top: 10px;
        color: red;
    }

    #phone-error,
    #name-error,
    #phone_check_error {
        margin-top: 5px;
        color: red;
    }

    .correct {
        color: green;
    }
</style>
<section class="login-rgstr service-section-three pujariji-background">
    <div class="auto-container">
        <div class="row align-items-center">
            @if(session()->get('pooja_language')=='English')
            <div class="col-lg-6 mx-auto booking-form-column">
                <div class="inner-column wow fadeInRight animated animated" data-wow-delay="200ms">
                    <div class="sec-title wow fadeInUp animated animated">
                        <h1>
                            Customer
                            <span>
                                Login
                            </span>
                        </h1>
                    </div>
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <strong>Error ! </strong>{{ $message }}
                    </div>
                    @endif
                    <div class="main-contact-area">
                        <form action="{{ route('customer.login') }}" class="login_form bk-form" name="sms_form"
                            id="sms_form" style="display:block;" method="POST">
                            @csrf
                            <div class="has-float-label frm-field" id="sms_form_div">
                                <input type="tel" class="form-control frm_rad" name="input_name" id="sms_number"
                                    placeholder="Mobile Number *"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10" required>
                                {{-- <small for="text-placeholder">Mobile Number *</small> --}}
                                <span id="phone_check_error"></span>
                            </div>
                            <div class="form-group floating-label">
                                <div id="sms_otp" style="display:none;" class="otp_send">
                                    <div class="single-form mt-3">
                                        <p class="text-center">An OTP has been sent to your <br> Mobile Number</p>
                                        <p class="mt-2 text-center"
                                            style="width: 100%; font-style: italic; color: gray;">Mobile Number:
                                            <span id="sms_otp_number">
                                            </span>
                                            <span>
                                                <a href="#" onclick="sms_edit_number()"> (Edit) </a>
                                            </span>
                                        </p>
                                        <div id="divOuter" class="m-auto">
                                            <div id="divInner">
                                                <input id="partitioned_sms" name="check_otp" type="text" maxlength="4"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==4) return false;" required>
                                            </div>
                                        </div>
                                        <p id="otp_error_sms" class="otp_send" style="text-align:center;"></p>
                                    </div>
                                    {{-- <p style="text-align:center"> <a href="javascript:void(0)"
                                            onclick="resend_otp()">Resend OTP</a> </p> --}}
                                    <div class="text-center form-submit">
                                        <button>Login <i class="fad fa-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div id="sms_form_button_div">
                                <div class="input-btn text-center form-submit">
                                    <a id="login_by_sms" class="btn btn-theme text-white btn-radius w-100"><i
                                            class="far fa-mobile"></i> Login with SMS OTP <i
                                            class="fad fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <div class="col-lg-6 mx-auto booking-form-column">
                <div class="inner-column wow fadeInRight animated animated" data-wow-delay="200ms">
                    <div class="sec-title wow fadeInUp animated animated">
                        <h1>
                            ग्राहक
                            <span>
                                लॉगिन
                            </span>
                        </h1>
                    </div>
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <strong>त्रुटि ! </strong>{{ $message }}
                    </div>
                    @endif
                    <div class="main-contact-area">
                        <form action="{{ route('customer.login') }}" class="login_form bk-form" name="sms_form"
                            id="sms_form" style="display:block;" method="POST">
                            @csrf
                            <div class="has-float-label frm-field" id="sms_form_div">
                                <input type="tel" class="form-control frm_rad" name="input_name" id="sms_number"
                                    placeholder="मोबाइल नंबर *"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10" required>
                                {{-- <small for="text-placeholder">मोबाइल नंबर *</small> --}}
                                <span id="phone_check_error"></span>
                            </div>
                            <div class="form-group floating-label">
                                <div id="sms_otp" style="display:none;" class="otp_send">
                                    <div class="single-form mt-3">
                                        <p class="text-center">आपके <br> मोबाइल नंबर पर एक OTP भेजा गया है</p>
                                        <p class="mt-2 text-center"
                                            style="width: 100%; font-style: italic; color: gray;">मोबाइल नंबर:
                                            <span id="sms_otp_number">
                                            </span>
                                            <span>
                                                <a href="#" onclick="sms_edit_number()"> (संपादित करें) </a>
                                            </span>
                                        </p>
                                        <div id="divOuter" class="m-auto">
                                            <div id="divInner">
                                                <input id="partitioned_sms" name="check_otp" type="text" maxlength="4"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==4) return false;" required>
                                            </div>
                                        </div>
                                        <p id="otp_error_sms" class="otp_send" style="text-align:center;"></p>
                                    </div>
                                    {{-- <p style="text-align:center"> <a href="javascript:void(0)"
                                            onclick="resend_otp()">OTP फिर से भेजें</a> </p> --}}
                                    <div class="text-center form-submit">
                                        <button>लॉगिन <i class="fad fa-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div id="sms_form_button_div">
                                <div class="input-btn text-center form-submit">
                                    <a id="login_by_sms" class="btn btn-theme text-white btn-radius w-100"><i
                                            class="far fa-mobile"></i> SMS OTP के माध्यम से लॉगिन करें <i
                                            class="fad fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>
</section>
@endsection
@push('scripts')
<script src="{{ asset('frontend/assets/js/jquery.validate.min.js') }}"></script>

<script>
    $.validator.addMethod("phoneIND", function(phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/[6789][0-9]{9}/);
        }, "Please specify a valid phone number");

        function validatePhoneNumber(input_str) {
            var re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
            return re.test(input_str);
        }


        $("#login_by_sms").click(function() {
            $('#sms_otp').hide();
            var phone = $('#sms_number').val();
            $('#phone_check_error').html('');

            if (phone.length == 10) {

                $.ajax({
                    type: "POST",
                    async: true,
                    dataType: 'json',
                    url: "{{ route('send_otp') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        phone: phone,
                        form_name: 'sms_form'
                    },
                    success: function(response) {

                        if (response.status == true) {
                            $('#phone_check_error').html('');
                            $('#sms_form_div').hide();
                            $('#sms_form_button_div').hide();
                            $('#login_by_sms').hide();
                            $('#sms_otp').show();
                            $('#sms_otp_number').text(phone);
                            var otp = response.otp;
                            console.log(response, 'otp')
                            $.validator.addMethod(
                                'otpcheck',
                                function(value, element) {
                                    return value == otp;
                                },
                                'Invalid OTP.'
                            );
                        } else {
                            alert('Invalid Phone Number');
                        }

                    }
                });
            } else {
                $('#sms_form').submit();
            }

        });

        function sms_edit_number() {
            $('#sms_form_div').show();
            $('#sms_form_button_div').show();
            $('#login_by_sms').show();
            $('#sms_otp').hide();
        }


        function resend_otp() {
            $('#otp').hide();
            $('#partitioned').val('');
            $('#partitioned-error').html('');
            var phone = $('#input_name').val();
            if (phone.length == 10) {

                $.ajax({
                    type: "POST",
                    async: true,
                    dataType: 'json',
                    url: "{{ route('send_otp') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        phone: phone
                    },
                    success: function(response) {

                        if (response.status == true) {
                            $('#otp').show();
                            var otp = response.otp;
                            $.validator.addMethod(
                                'otpcheck',
                                function(value, element) {
                                    return value == otp;
                                },
                                'Invalid OTP.'
                            );

                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: "success",
                                title: "OTP Resend!",
                                showCloseButton: true,
                            });
                        }
                        if (response.status == 'Wrong') {
                            $('#phone_error').html('Wrong Input !');

                        }
                    }
                });
            }
        };

        $("#partitioned").keyup(function() {
            var check_otp = $('#partitioned').val();
            $('#otp_error').html('');
            if (check_otp.length == 4) {
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
                        console.log(response);

                        if (response.status == true) {
                            $('#otp_error').html('OTP Verified !');
                            $('#otp_error').addClass('correct');
                            return true;
                        }
                        if (response.status == false) {
                            $('#otp_error').html('');
                            return false;
                        }

                    }
                });
            }
        });

        $("#partitioned_sms").keyup(function() {
            var check_otp = $('#partitioned_sms').val();
            $('#otp_error_sms').html('');
            if (check_otp.length == 4) {
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
                        console.log(response);

                        if (response.status == true) {
                            $('#otp_error_sms').html('OTP Verified !');
                            $('#otp_error_sms').addClass('correct');
                            return true;
                        }
                        if (response.status == false) {
                            $('#otp_error_sms').html('');
                            return false;
                        }

                    }
                });
            }
        });

        $(function() {

            $("form[name='sms_form']").validate({
                rules: {
                    input_name: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        phoneIND: true
                    },
                    check_otp: {
                        required: true,
                        otpcheck: true
                    },
                },
                messages: {

                    input_name: {
                        required: "Please Enter Mobile Number!",
                        minlength: "Please Enter 10 Digits",
                        maxlength: "Only 10 Digits Allow"
                    },
                    check_otp: {
                        required: "Please Enter OTP!",
                        otpcheck: "Invalid OTP!"
                    },
                },

                submitHandler: function(form) {
                    form.submit();
                }
            });
        });


        function display_form(id) {
            $('.login_form').hide();
            $('#' + id).show();
        }
</script>
@endpush