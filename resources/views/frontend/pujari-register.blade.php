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
        #phone_check_error #sms_number-error {}

        .correct {
            color: green;
        }

        .error {
            color: red;
        }

        /* Wrapper to position icon inside input */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Custom styling for input */
        .input-wrapper input {
            width: 100%;
            padding-right: 40px;
            /* Space for the icon */
        }

        /* Styling the icon */
        .location-icon {
            position: absolute;
            right: 10px;
            /* Adjust icon position */
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            /* Icon color */
            font-size: 18px;
            pointer-events: none;
            /* Prevent click interference */
        }

        .form-user-img {
            width: 100px;
            height: 100px;
            border-radius: 100%;
        }

        .camera-icon {
            width: 30px;
            position: relative;
            margin-top: -35px;
        }
    </style>

    <section class="login-rgstr service-section-three pujariji-background">
        <div class="auto-container">
            <div class="row align-items-center">
                @if (session()->get('pooja_language') == 'English')
                    <div class="col-lg-9 mx-auto booking-form-column">
                        <div class="inner-column wow fadeInRight animated animated" data-wow-delay="200ms">
                            <div class="sec-title wow fadeInUp animated animated">
                                <h1>
                                   Pujariji Registration
                                    <span>
                                        Register
                                    </span>
                                </h1>
                            </div>
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Error ! </strong>{{ $message }}
                                </div>
                            @endif
                            <form action="{{ route('pujari_data.register') }}" class="login_form bk-form" name="sms_form"
                                id="sms_form" style="display:block;" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="has-float-label" id="sms_form_div">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center d-flex flex-column">
                                                <label for="photo">
                                                    <img src="{{ asset('frontend/user.png') }}"class="form-user-img preview"
                                                        height="100" width="100" id="preview">
                                                </label>
                                                <input type="file" name="logo" id="photo" hidden accept="image/*">
                                                <div class="justify-content-center">
                                                    <label for="photo">
                                                        <img src="{{ asset('frontend/camera.png') }}" class="camera-icon">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="name" class="form-label">Name</label>
                                                <input name="name" id="name" class="form-control" type="text"
                                                    placeholder="Enter Your Name *" required>
                                                <span
                                                    style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;"
                                                    role="alert">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="tel" class="form-control frm_rad" name="phone"
                                                    id="phone" placeholder="Mobile Number *"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10"
                                                    required>
                                                <span
                                                    style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;"
                                                    role="alert">
                                                    {{ $errors->first('phone') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="dob" class="form-label">Date Of Birth</label>
                                                <input type="date" class="form-control frm_rad" name="dob"
                                                    id="dob" placeholder="dob" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="father_name" class="form-label">Father Name</label>
                                                <input name="father_name" id="father_name" class="form-control"
                                                    type="text" placeholder="Enter Your Father Name *" required>
                                                <span
                                                    style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;"
                                                    role="alert">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="experince" class="form-label">Experience</label>
                                                <input type="number" class="form-control frm_rad" name="Experience"
                                                    id="experince" placeholder="experince"
                                                    placeholder="Experience in year for pooja" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="category" class="form-label">Category</label>
                                                <select id="category" class="form-select frm_rad select2"
                                                    aria-label="Category" name="category[]" id="category" multiple
                                                    required>
                                                    <option value="">Select Category</option>
                                                    @foreach (App\Models\Category::get() as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="city" class="form-label">Terth City</label>
                                                <select class="form-select frm_rad select2" aria-label="City"
                                                    name="terth_city[]" id="terth_city" multiple>
                                                    @foreach (App\Models\TerthPujaCity::all() as $t_city)
                                                        <option value="{{ $t_city->id }}">{{ $t_city->city }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="language" class="form-label">Language</label>
                                                <select class="form-select frm_rad select2" aria-label="Language"
                                                    name="language[]" id="language" multiple required>
                                                    <option value="">Select Language</option>
                                                    @foreach (App\Models\Language::all() as $language)
                                                        <option value="{{ $language->id }}"> {{ $language->language }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="city" class="form-label">Service City</label>
                                                <select class="form-select select2" aria-label="City" name="city[]"
                                                    id="city" onchange="getPincode()" multiple required>
                                                    @foreach (App\Models\ServiceCity::all() as $city)
                                                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="pincode" class="form-label">Pincode</label>
                                                <select id="pincode" class="form-select select2" aria-label="Pincode"
                                                    name="pincode[]" id="pincode" multiple required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="frm-field">
                                                <label for="address" class="form-label">Address</label>
                                                <div class="input-wrapper">
                                                    <input type="text" class="form-control frm_rad" name="address"
                                                        id="address" placeholder="Enter Address" required>
                                                    <i class="fa fa-map-marker-alt location-icon"><a
                                                            href=""></a></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-check">
                                                <input class="form-check-input" name="term_and_condition" type="checkbox"
                                                    value="" id="term_and_condition" required>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Accept Term & Condition
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group floating-label">
                                            <div id="sms_otp" style="display:none;" class="otp_send">
                                                <div class="single-form mt-3">
                                                    <p class="text-center">An OTP has been sent to your <br> Mobile Number
                                                    </p>
                                                    <p class="mt-2 text-center"
                                                        style="width: 100%; font-style: italic; color: gray;">Mobile
                                                        Number:
                                                        <span id="sms_otp_number"></span><span><a href="#"
                                                                onclick="sms_edit_number()"> (Edit) </a></span>
                                                    </p>
                                                    <div id="divOuter" class="m-auto">
                                                        <div id="divInner">
                                                            <input id="partitioned_sms" name="check_otp" type="text"
                                                                maxlength="4"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                                onKeyPress="if(this.value.length==4) return false;"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <span id="otp_error_sms" class="otp_send"
                                                        style="margin-left: 100px;"></span>
                                                </div>
                                                <div class="text-center form-submit">
                                                    <button>Login <i class="fad fa-angle-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div id="sms_form_button_div">
                                                <div class="input-btn text-center form-submit">
                                                    <button class="btn btn-theme text-white btn-radius w-100">
                                                        <i class="far fa-mobile"></i>
                                                        Register
                                                        <i class="fad fa-angle-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="col-lg-9 mx-auto booking-form-column">
                        <div class="inner-column wow fadeInRight animated animated" data-wow-delay="200ms">
                            <div class="sec-title wow fadeInUp animated animated">
                                <h1>
                                    पुजारी जी रजिस्ट्रेशन
                                    <span>
                                        रजिस्टर करें
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
                            <form action="{{ route('pujari_data.register') }}" class="login_form bk-form"
                                name="sms_form" id="sms_form" style="display:block;" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="has-float-label" id="sms_form_div">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center d-flex flex-column">
                                                <label for="photo">
                                                    <img src="{{ asset('frontend/user.png') }}"class="form-user-img preview"
                                                        height="100" width="100" id="preview">
                                                </label>
                                                <input type="file" name="logo" id="photo" hidden
                                                    accept="image/*">
                                                <div class="justify-content-center">
                                                    <label for="photo">
                                                        <img src="{{ asset('frontend/camera.png') }}"
                                                            class="camera-icon">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="name" class="form-label">नाम</label>
                                                <input name="name" id="name" class="form-control" type="text"
                                                    placeholder="अपना नाम दर्ज करें *" required>
                                                <span
                                                    style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;"
                                                    role="alert">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="phone" class="form-label">फोन</label>
                                                <input type="tel" class="form-control frm_rad" name="phone"
                                                    id="phone" placeholder="मोबाइल नंबर *"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onKeyPress="if(this.value.length==10) return false;" maxlength="10"
                                                    required>
                                                <span
                                                    style="display: block; width: 100%;margin-top: 0.25rem;font-size: 80%;color: #dc3545;"
                                                    role="alert">
                                                    {{ $errors->first('phone') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="dob" class="form-label">जन्म तिथि</label>
                                                <input type="date" class="form-control frm_rad" name="dob"
                                                    id="dob" placeholder="जन्म तिथि" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="father_name" class="form-label">पिता का नाम</label>
                                                <input name="father_name" id="father_name" class="form-control"
                                                    type="text" placeholder="अपने पिता का नाम दर्ज करें *" required>
                                                <span
                                                    style="display: block; width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545;"
                                                    role="alert">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="experince" class="form-label">अनुभव</label>
                                                <input type="text" class="form-control frm_rad" name="experince"
                                                    id="experince" placeholder="अनुभव" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="category" class="form-label">श्रेणी</label>
                                                <select id="category" class="form-select frm_rad select2"
                                                    aria-label="श्रेणी" name="category[]" multiple required>
                                                    <option value="">श्रेणी चुनें</option>
                                                    @foreach (App\Models\Category::get() as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name_hindi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="city" class="form-label">तीर्थ शहर</label>
                                                <select class="form-select frm_rad select2" aria-label="शहर"
                                                    name="terth_city[]" multiple>
                                                    @foreach (App\Models\TerthPujaCity::all() as $t_city)
                                                        <option value="{{ $t_city->id }}">{{ $t_city->city_hindi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="language" class="form-label">भाषा</label>
                                                <select class="form-select frm_rad select2" aria-label="भाषा"
                                                    name="language[]" multiple required>
                                                    <option value="">भाषा चुनें</option>
                                                    @foreach (App\Models\Language::all() as $language)
                                                        <option value="{{ $language->id }}"> {{ $language->language }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="city" class="form-label">सेवा शहर</label>
                                                <select class="form-select select2" aria-label="शहर" name="city[]"
                                                    id="city" onchange="getPincode()" multiple required>
                                                    @foreach (App\Models\ServiceCity::all() as $city)
                                                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="frm-field">
                                                <label for="pincode" class="form-label">पिन कोड</label>
                                                <select id="pincode" class="form-select select2" aria-label="पिन कोड"
                                                    name="pincode[]" multiple required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="frm-field">
                                                <label for="address" class="form-label">पता</label>
                                                <div class="input-wrapper">
                                                    <input type="text" class="form-control frm_rad" name="address"
                                                        id="address" placeholder="पता दर्ज करें" required>
                                                    <i class="fa fa-map-marker-alt location-icon"><a
                                                            href=""></a></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-check">
                                                <input class="form-check-input" name="term_and_condition" type="checkbox"
                                                    value="" id="term_and_condition" required>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    नियम एवं शर्तें स्वीकार करें
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div id="sms_form_button_div">
                                                <div class="input-btn text-center form-submit">
                                                    <button class="btn btn-theme text-white btn-radius w-100">
                                                        <i class="far fa-mobile"></i>
                                                        पंजीकरण करें
                                                        <i class="fad fa-angle-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/assets/js/jquery.validate.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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


        // $("#login_by_sms").click(function() {
        //     $('#sms_otp').hide();
        //     var phone = $('#sms_number').val();
        //     var name = $('#name').val();
        //     $('#phone_check_error').html('');
        //     const checkbox = document.getElementById('term_and_condition');
        //     if (checkbox.checked) {
        //         if (phone.length == 10) {
        //             $.ajax({
        //                 type: "POST",
        //                 async: true,
        //                 dataType: 'json',
        //                 url: "{{ route('pujari.send_otp') }}",
        //                 data: {
        //                     _token: '{{ csrf_token() }}',
        //                     phone: phone,
        //                     name: name,
        //                     form_name: 'sms_form',

        //                 },
        //                 success: function(response) {

        //                     if (response.status == true) {
        //                         $('#phone_check_error').html('');
        //                         $('#sms_form_div').hide();
        //                         $('#sms_form_button_div').hide();
        //                         $('#login_by_sms').hide();
        //                         $('#sms_otp').show();
        //                         $('#sms_otp_number').text(phone);
        //                         var otp = response.otp;
        //                         $.validator.addMethod(
        //                             'otpcheck',
        //                             function(value, element) {
        //                                 return value == otp;
        //                             },
        //                             'Invalid OTP.'
        //                         );
        //                     } else {
        //                         alert('Invalid Phone Number');
        //                     }

        //                 }
        //             });
        //         } else {
        //             $('#sms_form').submit();
        //         }
        //     } else {
        //         alert('Please Check Term and Condition.');
        //     }


        // });

        // function sms_edit_number() {
        //     $('#sms_form_div').show();
        //     $('#sms_form_button_div').show();
        //     $('#login_by_sms').show();
        //     $('#sms_otp').hide();
        // }


        // function resend_otp() {
        //     $('#otp').hide();
        //     $('#partitioned').val('');
        //     $('#partitioned-error').html('');
        //     var phone = $('#input_name').val();
        //     if (phone.length == 10) {

        //         $.ajax({
        //             type: "POST",
        //             async: true,
        //             dataType: 'json',
        //             url: "{{ route('pujari.send_otp') }}",
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 phone: phone
        //             },
        //             success: function(response) {

        //                 if (response.status == true) {
        //                     $('#otp').show();
        //                     var otp = response.otp;
        //                     $.validator.addMethod(
        //                         'otpcheck',
        //                         function(value, element) {
        //                             return value == otp;
        //                         },
        //                         'Invalid OTP.'
        //                     );

        //                     var Toast = Swal.mixin({
        //                         toast: true,
        //                         position: 'top-end',
        //                         showConfirmButton: false,
        //                         timer: 3000
        //                     });

        //                     Toast.fire({
        //                         icon: "success",
        //                         title: "OTP Resend!",
        //                         showCloseButton: true,
        //                     });
        //                 }
        //                 if (response.status == 'Wrong') {
        //                     $('#phone_error').html('Wrong Input !');

        //                 }
        //             }
        //         });
        //     }
        // };

        // $("#partitioned").keyup(function() {
        //     var check_otp = $('#partitioned').val();
        //     $('#otp_error').html('');
        //     if (check_otp.length == 4) {
        //         $.ajax({
        //             type: "POST",
        //             async: false,
        //             dataType: 'json',
        //             url: "{{ route('pujari.check_otp') }}",
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 otp: check_otp
        //             },
        //             success: function(response) {
        //                 console.log(response);

        //                 if (response.status == true) {
        //                     $('#otp_error').html('OTP Verified !');
        //                     $('#otp_error').addClass('correct');
        //                     return true;
        //                 }
        //                 if (response.status == false) {
        //                     $('#otp_error').html('');
        //                     return false;
        //                 }

        //             }
        //         });
        //     }
        // });

        // $("#partitioned_sms").keyup(function() {
        //     var check_otp = $('#partitioned_sms').val();
        //     $('#otp_error_sms').html('');
        //     if (check_otp.length == 4) {
        //         $.ajax({
        //             type: "POST",
        //             async: false,
        //             dataType: 'json',
        //             url: "{{ route('pujari.check_otp') }}",
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 otp: check_otp
        //             },
        //             success: function(response) {
        //                 console.log(response);

        //                 if (response.status == true) {
        //                     $('#otp_error_sms').html('OTP Verified !');
        //                     $('#otp_error_sms').addClass('correct');
        //                     return true;
        //                 }
        //                 if (response.status == false) {
        //                     $('#otp_error_sms').html('');
        //                     return false;
        //                 }

        //             }
        //         });
        //     }
        // });

        $(function() {

            $("form[name='sms_form']").validate({
                rules: {
                    input_name: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        phoneIND: true
                    },
                    name: {
                        required: true,
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
                    name: {
                        required: "Please Enter Name!",
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
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Choose one thing",
                allowClear: true
            });

        });

        function getPincode() {
            var city_id = $('#city').val();
            $.ajax({
                url: "{{ route('pujari.get-pincode') }}", // Laravel route
                type: "POST",
                data: {
                    city_id: city_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#pincode').empty();
                    console.log(response);

                    $.each(response, function(key, city) {
                        $('#pincode').append(
                            `<option value="${city.pincode}">${city.pincode}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }
    </script>
    <script>
        document.getElementById('photo').addEventListener('change', function(event) {
            let reader = new FileReader();
            reader.onload = function(){
                let previews = document.querySelectorAll('.preview');
                previews.forEach(preview => {
                    preview.src = reader.result;
                });
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endpush
