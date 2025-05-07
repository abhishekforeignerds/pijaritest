@extends('frontend.layouts.app')

@section('meta')
        @if (!empty(appSetupValue('app_name')))
        <title>{{(appSetupValue('app_name'))}}</title>
        @endif
        <meta name="title" content="">
        <meta name="description" content="">
        <meta name="keywords" content="">
@endsection


@section('content')
    <style>
        .float i {
            padding-top: 0;
        }

        .aiz-megabox {
            cursor: pointer;
            text-align: center;
        }

        .aiz-megabox input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .checkout-payment-method .aiz-megabox-elem h5 {
            text-align: center;
            font-size: 16px !important;
            letter-spacing: 0.2px;
            line-height: 25px;
            font-weight: 500 !important;
            text-transform: uppercase;
        }

        .checkout-payment-method .aiz-megabox-elem img {
            width: 60%;
            margin-bottom: 10px;
        }

        .checkout-payment-method {
            text-align: center
        }

        .aiz-megabox>input:checked~.aiz-megabox-elem,
        .aiz-megabox>input:checked~.aiz-megabox-elem {
            background-image: linear-gradient(315deg, #ff320099 0%, #f9d9764d 74%);
            color: #fff;
        }

        .aiz-megabox>input:checked~.aiz-megabox-elem,
        .aiz-megabox>input:checked~.aiz-megabox-elem h5 {
            color: #fff;
        }

        .aiz-megabox .aiz-megabox-elem {
            background: #fffefe;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
        }
    </style>


    <section>
        <div class="auto-container">
            <div class="row align-items-center">
                <div class="login-rgstr">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form id="order_form" action="{{ route('astrology.save') }}" method="POST" class="login_form bk-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-10 mx-auto booking-form-column">
                                <div class="inner-column">
                                    <div class="sec-title"> <span class="sub-title">Kundali</span>
                                        <h2>Request for Kundali</h2>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 col-md-6">
                                            <label for="checkuot-form-fname">Full Name <span>*</span></label>
                                            <input id="checkuot-form-fname" type="text" name="name"
                                                class="form-control" placeholder="Full Name" required>
                                        </div>
                                        <div class="mb-2 col-md-6">
                                            <label for="checkuot-form-dob">Phone <span>*</span></label>
                                            <input id="checkuot-form-phone" type="number" name="phone"
                                                class="form-control" placeholder="Phone Number" required>
                                        </div>
                                        <div class="mb-2 col-md-6">
                                            <label for="checkuot-form-dob">DOB <span>*</span></label>
                                            <input id="checkuot-form-dob" type="date" name="dob" class="form-control"
                                                placeholder="Date of Birth" required>
                                        </div>

                                        <div class="mb-2 col-md-6">
                                            <label for="checkuot-form-tob">Time of Birth <span>*</span></label>
                                            <input id="checkuot-form-tob" type="time" name="tob" class="form-control"
                                                placeholder="Time of Birth" required>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="checkuot-form-pob">POB <span>*</span> </label>
                                                <input id="checkuot-form-pob" name="pob" type="text"
                                                    class="form-control" placeholder="Place of Birth">
                                            </div>
                                        </div>
                                        <div class="mb-2 col-md-6">
                                            <label for="checkuot-form-language">Language <span>*</span></label>
                                            <select class="form-control" name="language" required>
                                                <option>Select Language</option>
                                                <option value="hi">Hindi</option>
                                                <option value="en">English</option>
                                            </select>
                                        </div>

                                        <div class="mb-2 col-md-6">
                                            <label>PDF Type <span>*</span></label>
                                            <select class="form-control" name="pdf_type" required>
                                                <option>Select PDF Type</option>
                                                <option value="25 Page">25 Page</option>
                                                <option value="30 Page">30 Page</option>
                                                <option value="54 Page">54 Page</option>
                                            </select>
                                        </div>

                                        <div class="mb-2 col-md-12">
                                            <label for="checkuot-form-address">Address <span>*</span></label>
                                            <input id="checkuot-form-address" type="text" name="address"
                                                class="form-control" placeholder="address" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-10 mx-auto booking-form-column">
                                <div class="inner-column">
                                    <div class="row">
                                        <div class="col-lg-4 col-4 col-sm-4">
                                            <div class="checkout-payment-method">
                                                <label class="aiz-megabox d-block single-method">
                                                    <input type="radio" name="package_id" checked>
                                                    <span class="d-block aiz-megabox-elem">
                                                        <img src="{{ asset('frontend/assets/images/kundli.png') }}"
                                                            class="img-fluid" />
                                                        <h5>Kundali Report 25 Page <br><b>₹501</b></h5>
                                                    </span>
                                                </label>
                                                <button type="button" class="btn btn-danger">View Kundali Sample</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-4 col-sm-4">
                                            <div class="checkout-payment-method">
                                                <label class="aiz-megabox d-block single-method">
                                                    <input type="radio" name="package_id">
                                                    <span class="d-block aiz-megabox-elem">
                                                        <img src="{{ asset('frontend/assets/images/kundli.png') }}"
                                                            class="img-fluid" />

                                                        <h5>Kundali Report 30 Page <br><b>₹1101</b></h5>
                                                    </span>
                                                </label>
                                                <button type="button" class="btn btn-danger">View Kundali Sample</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-4 col-sm-4">
                                            <div class="checkout-payment-method">
                                                <label class="aiz-megabox d-block single-method">
                                                    <input type="radio" name="package_id">
                                                    <span class="d-block aiz-megabox-elem">
                                                        <img src="{{ asset('frontend/assets/images/kundli.png') }}"
                                                            class="img-fluid" />
                                                        <h5>Kundali Report 54 Page <br><b>₹1501</b></h5>
                                                    </span>
                                                </label>

                                                <button type="button" class="btn btn-danger">View Kundali Sample</button>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-20">
                                            <h5>Kundali Report 25 Page</h5>
                                            <p class="text-justify">Pujari Ji is the most trusted platform for availing
                                                Vedic and Hindu Puja Services like performing Vedic Rituals, Religious
                                                Ceremonies, Vastu Yagya and many more. We provide the best experienced and
                                                well-known purohits and pandits at your place to do puja. We are leading
                                                Pandit Booking website. Now, you can perform your pooja with our
                                                Professional Purohits & Pandits.</p>
                                        </div>

                                        <div class="col-md-12">
                                            <h5>Kundali Report 30 Page</h5>
                                            <p class="text-justify">Pujari Ji is the most trusted platform for availing
                                                Vedic and Hindu Puja Services like performing Vedic Rituals, Religious
                                                Ceremonies, Vastu Yagya and many more. We provide the best experienced and
                                                well-known purohits and pandits at your place to do puja. We are leading
                                                Pandit Booking website. Now, you can perform your pooja with our
                                                Professional Purohits & Pandits.</p>
                                        </div>

                                        <div class="col-md-12">
                                            <h5>Kundali Report 54 Page</h5>
                                            <p class="text-justify">Pujari Ji is the most trusted platform for availing
                                                Vedic and Hindu Puja Services like performing Vedic Rituals, Religious
                                                Ceremonies, Vastu Yagya and many more. We provide the best experienced and
                                                well-known purohits and pandits at your place to do puja. We are leading
                                                Pandit Booking website. Now, you can perform your pooja with our
                                                Professional Purohits & Pandits.</p>
                                        </div>

                                        <div class="mt-4 col-md-12 mt-10">
                                            <button class="theme-btn btn-style-one" type="submit"><span
                                                    class="btn-title">Submit</span> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
