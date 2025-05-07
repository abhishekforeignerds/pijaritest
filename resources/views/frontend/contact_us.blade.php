@extends('frontend.layouts.app')

@section('meta')
    <title>Puajri Ji</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('content')
    <section class="contact-us">
        <div class="auto-container">
            @if (session()->get('pooja_language') == 'English')
                <div class="row g-5 mt-2">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="rbt-address">
                            <div class="icon">
                                <i class="fa fa-headphones"></i>
                            </div>
                            <div class="inner">
                                <h4 class="title">Contact Phone Number</h4>
                                <a
                                    href="tel:+91-{{ appSetupValue('contact_number') }}">+91-{{ appSetupValue('contact_number') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="rbt-address">
                            <div class="icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="inner">
                                <h4 class="title">Our Email Address</h4>
                                <a href="mailto:{{ appSetupValue('email') }}">{{ appSetupValue('email') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="thumbnail-img">
                            <img src="{{ asset('frontend/assets/images/contact-img.jpg') }}" alt=""
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form id="order_form" action="{{ route('enquiryStore') }}" method="POST"
                                class="login_form bk-form">
                                @csrf
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <label for="checkuot-form-fname">Full Name <span>*</span></label>
                                        <input id="checkuot-form-fname" type="text" name="name" class="form-control"
                                            placeholder="Full Name" required>
                                    </div>
                                    <div class="mb-2 col-md-12">
                                        <label for="checkuot-form-phone">Phone <span>*</span></label>
                                        <input id="checkuot-form-phone" type="number" name="phone" class="form-control"
                                            placeholder="Phone Number" required>
                                    </div>
                                    <div class="mb-2 col-md-12">
                                        <label for="checkuot-form-phone">Email </label>
                                        <input id="checkuot-form-phone" type="email" name="email" class="form-control"
                                            placeholder="Enter Your Email">
                                    </div>
                                    <div class="mb-2 col-md-12">
                                        <label for="checkuot-form-message">Message <span>*</span></label>
                                        <input id="checkuot-form-message" type="text" name="message" class="form-control"
                                            placeholder="Enter Your Message" required>
                                    </div>

                                    <div class="mb-3 mt-3 col-md-12">
                                        <button class="theme-btn btn-style-one w-100" type="submit"><span
                                                class="btn-title">Submit</span> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-5 mt-2">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="rbt-address">
                            <div class="icon">
                                <i class="fa fa-headphones"></i>
                            </div>
                            <div class="inner">
                                <h4 class="title">संपर्क फ़ोन नंबर</h4>
                                <a
                                    href="tel:+91-{{ appSetupValue('contact_number') }}">+91-{{ appSetupValue('contact_number') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="rbt-address">
                            <div class="icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="inner">
                                <h4 class="title">हमारा ईमेल पता</h4>
                                <a href="mailto:{{ appSetupValue('email') }}">{{ appSetupValue('email') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="thumbnail-img">
                            <img src="{{ asset('frontend/assets/images/contact-img.jpg') }}" alt=""
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>सफलता!</strong> {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form id="order_form" action="{{ route('enquiryStore') }}" method="POST"
                                class="login_form bk-form">
                                @csrf
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <label for="checkuot-form-fname">पूरा नाम <span>*</span></label>
                                        <input id="checkuot-form-fname" type="text" name="name"
                                            class="form-control" placeholder="पूरा नाम" required>
                                    </div>
                                    <div class="mb-2 col-md-12">
                                        <label for="checkuot-form-phone">फ़ोन <span>*</span></label>
                                        <input id="checkuot-form-phone" type="number" name="phone"
                                            class="form-control" placeholder="फ़ोन नंबर" required>
                                    </div>
                                    <div class="mb-2 col-md-12">
                                        <label for="checkuot-form-phone">ईमेल</label>
                                        <input id="checkuot-form-phone" type="email" name="email"
                                            class="form-control" placeholder="अपना ईमेल दर्ज करें">
                                    </div>
                                    <div class="mb-2 col-md-12">
                                        <label for="checkuot-form-message">संदेश <span>*</span></label>
                                        <input id="checkuot-form-message" type="text" name="message"
                                            class="form-control" placeholder="अपना संदेश लिखें" required>
                                    </div>

                                    <div class="mb-3 mt-3 col-md-12">
                                        <button class="theme-btn btn-style-one w-100" type="submit"><span
                                                class="btn-title">सबमिट करें</span> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
