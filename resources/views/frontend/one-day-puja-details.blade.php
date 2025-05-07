@extends('frontend.layouts.app')

@section('meta')
<title>{{ $product->meta_title ?: $product->name }}</title>
<meta name="description" content="{{ $product->meta_description ?: $product->name }}">
<meta name="keywords" content="{{ $product->meta_keywords ?: $product->name }}">
@endsection

@section('content')
<style>
    html {
        scroll-behavior: smooth;
    }

    .hidden {
        display: none !important;
    }

    .description {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        text-overflow: ellipsis;
        transition: all 0.3s ease-in-out;
        /* max-height: 150px; */
    }

    .description.full {
        -webkit-line-clamp: unset;
        overflow: visible;
        display: block;
        max-height: none;
    }

    .read-more-btn {
        background: none;
        border: none;
        color: #c64d04;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
    }


    .icon-form {
        padding: 10px;
        background: #c64d04;
        color: white;
        min-width: 50px;
        text-align: center;
        font-size: 18px;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        outline: none;
    }

    .input-container {
        display: flex;
        width: 100%;
        margin-bottom: 5px;
    }

    .divide {
        scroll-margin-top: 200px;
        overflow: clip;
    }
</style>

@if (session()->get('pooja_language') == 'English')

<div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        <ul class="page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('one-day-puja') }}">E-Puja</a></li>
            <li class="breadcrumb-item">{{ $product->name }}</li>
        </ul>
    </div>
</div>
<section class="product-details mb-4">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-5">
                <div class="swiper product_slider">
                    <div class="swiper-wrapper">
                        @if (isset($product->photos))
                        @foreach ($product->photos as $product_image)
                        <div class="swiper-slide">
                            <img src="{{ uploaded_asset($product_image) }}" alt="image"
                                onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                        </div>
                        @endforeach
                        @else
                        <img src="{{ asset('frontend/pujari/placeholder.jpeg') }}" alt="image">
                        @endif
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="product_info_pujari product-info">
                    <div class="product-details__top">
                        <h3 class="product-details__title">{{ $product->name }}</h3>
                        <div class="product-details__content">
                            {!! $product->short_description !!}
                        </div>
                        <p class="mb-0">
                            <img src="{{asset('frontend/assets/images/temple_venue.svg')}}" class="wh-20"> :
                            @if (isset($temple_detail->title))
                            <span>{{ $temple_detail->title }}</span>
                            @endif
                        </p>
                        <p class="mb-0">
                            <img src="{{asset('frontend/assets/images/date.svg')}}" class="wh-20"> :
                            <span>{{ \Carbon\Carbon::parse($product->date)->format('l, j F Y') }},
                                {{ $product->tithi }}</span>
                        </p>
                    </div>
                    <div class="pooja-at">
                        <div class="row">
                            <div class="col-md-6">
                                <b>Puja booking will close in ::</b>
                                <div id="countdown" class="d-flex relative w-full mt-2">
                                    <ul class="d-flex w-full justify-content-between flex-1">
                                        <li class="timer"><span id="days"></span> <sub>Days</sub></li>
                                        <li class="timer"><span id="hours"></span> <sub>Hours</sub></li>
                                        <li class="timer"><span id="minutes"></span> <sub>Minutes</sub></li>
                                        <li class="timer"><span id="seconds"></span> <sub>Seconds</sub></li>
                                    </ul>
                                </div>
                                <div id="content" style="display: none;">
                                    <h2 style="color:red;">Booking Closed</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rating">
                                <p class="color-or"><i class="fa-solid fa-star"></i> 4.9 (7K+ ratings)
                                </p>
                            </div>
                            {{-- <div class="select-language ">
                                <select name="pooja_language" id="pooja_language" onchange="set_pooja_language()">
                                    <option value="">Select Language</option>
                                    @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                    <option value="{{ $language->language }}" @if (session()->get('pooja_language') ==
                                        $language->language) selected @endif>
                                        {{ $language->language }}
                                    </option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>
                        <div class="col-12">
                            <p> Till now <strong class="text-danger">{{ $product->fake_devote }}+
                                </strong> Devotees
                                already booked this Puja by Pujari ji.</p>
                        </div>
                    </div>
                    <div class="product-details__buttons-1 pujari_pooja_btn mt-auto" id="package_button">
                        <a href="#packages">
                            <span class="theme-btn btn-style-one w-100"> Select Puja
                                Package <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-description">
    <div class="product-nav">
        <ul class="nav d-flex justify-content-between align-items-center">
            <li class="nav-item">
                <a class="nav-link active" id="about-link" href="#about">About Puja</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="benefits-link" href="#benefits">Benefits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="process-link" href="#process">Process</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="temple-details-link" href="#temple_details">Temple Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="packages-link" href="#packages">Packages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="review-link" href="#review">Testimonials</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="faq-link" href="#faq">Faq's</a>
            </li>
        </ul>
    </div>
    <div class="auto-container">
        <div class="text divide" id="about">
            <div class="row">
                <div class="col-lg-12">
                    {!! $product->description !!}
                </div>
            </div>
        </div>
        <div class="text divide" id="benefits">
            <div class="row">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>Puja Benifits</h1>
                    </div>
                </div>
                @foreach ($puja_benifit as $benefit)
                <div class="col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="title text-danger">
                                <img src="{{ asset('frontend/icons/s-icon.png') }}" style="width: 25px;">
                                {{ $benefit->title }}
                            </h5>
                            {!! $benefit->description !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="text-1 divide" id="process">
            <div class="row">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>Puja Process</h1>
                    </div>
                </div>
                <div class="pooja-process-scroll">
                    <div class="row flex-nowrap pooja-process-new">
                        <div class="col">
                            <div class="arrow-card">
                                <span class="arrow-heading">1</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600"> Select a
                                            Worship Package</h3>
                                    </div>
                                    <p class="card-text font_black_14">Choose a worship and package based on your
                                        needs, such as individual, couple, or
                                        family worship.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="arrow-card">
                                <span class="arrow-heading">2</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600"> Add
                                            Offerings</h3>
                                    </div>
                                    <p class="card-text font_black_14">Along with your worship, select additional
                                        options like cow service, lamp
                                        donation, cloth donation, food donation, and Brahmin offerings.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="arrow-card">
                                <span class="arrow-heading">3</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600"> Provide
                                            Sankalp Details</h3>
                                    </div>
                                    <p class="card-text font_black_14">Fill out the Sankalp form with your name,
                                        lineage (Gotra), and address (if
                                        applicable) based on the chosen worship.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="arrow-card">
                                <span class="arrow-heading">4</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600"> Complete
                                            Payment</h3>
                                    </div>
                                    <p class="card-text font_black_14">Make the payment to confirm your
                                        participation in the selected worship. Receive
                                        real-time updates of the puja on your registered WhatsApp number.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="arrow-card">
                                <span class="arrow-heading">5</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600"> Worship
                                            Prasad and Video</h3>
                                    </div>
                                    <p class="card-text font_black_14">A video of the worship performed with your
                                        name and lineage will be shared with
                                        you within 3-4 days and will also be available on your profile. The Prasad
                                        will
                                        be sent to the provided address within 8-10 days.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text divide mt-4" id="temple_details">
            <div class="row">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1 class="text-dark">Temple Details</h1>
                    </div>
                </div>
            </div>
            @if (!empty($temple_detail->id))
            <div class="row px-2">
                <div class="col-lg-4">
                    <figure class="image-box">
                        <img src="{{ uploaded_asset($temple_detail->image) }}" alt="image" class="rounded-3"
                            onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                    </figure>
                </div>
                <div class="col-lg-8">
                    <h4 class="text-dark">{{ $temple_detail->title }}</h4>
                    <div class="desc">{!! $temple_detail->description !!}</div>
                    <button class="read-more-btn">Read More</button>
                </div>
            </div>
            @endif
        </div>
        <div id="test"></div>
        <div class="text divide" id="packages">
            <div class="row">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>Select puja package</h1>
                    </div>
                </div>
                <div class="col-sm-12 d-block d-sm-none">
                    <div class="all_packages">
                        <div class="packages-wrapper">
                            @foreach ($package_list as $index => $package_data)
                            <div class="package-card" data-package-id="{{ $package_data->id }}"
                                onclick="showPackage({{ $package_data->id }})">
                                <p class="package-name">{{ $package_data->package_name }}</p>
                                <div class="pack-money">
                                    <small class="package-price">₹ {{ $package_data->discount_price }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

                <div class="package-slider swiper">
                    <div class="swiper-wrapper">
                        @foreach ($package_list as $index => $package_data)
                        <div class="swiper-slide">
                            <div class="card puja-card">
                                <div class="card-body">
                                    <div class="card-img">
                                        <img src="{{ uploaded_asset($package_data->image) }}"
                                            onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                                    </div>
                                    <h6 class="card-title mt-1">
                                        <a href="{{ route('one_day_product_package', $package_data->id) }}">
                                            {{ $package_data->package_name }} (Person : {{ $package_data->no_of_people
                                            }})
                                        </a>
                                    </h6>
                                    <div class="price">
                                        <h5 class="text-center">₹ {{ $package_data->discount_price }}</h5>
                                    </div>
                                    <div class="description short">{!! $package_data->description !!}</div>
                                    <button class="read-more-btn">Read More</button>
                                    <div class="content">
                                        <a href="{{ route('one_day_product_package', $package_data->id) }}"
                                            class="theme-btn btn-style-one read-more w-100">
                                            PARTICIPATE
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Swiper navigation buttons -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                    <!-- Swiper pagination (optional) -->
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </div>
        @if ($review_list->count() > 0)
        <div class="customer-comment text product-discription divide" id="review">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>Review</h1>
                    </div>
                </div>
                <div class="carousel-outer">
                    <div class="swiper review-slider">
                        <div class="swiper-wrapper">
                            @foreach ($review_list as $review)
                            <div class="swiper-slide">
                                <div class="single-comment-box">
                                    <div class="inner-box">
                                        <figure class="comment-thumb">
                                            <img src="{{ $review->userData->profile_picture }}" alt="img"
                                                onerror="this.src='{{ asset('frontend/assets/images/customer.png') }}';">
                                        </figure>
                                        <div class="inner">
                                            <ul class="rating clearfix">
                                                @for ($i = 1; $i <= 5; $i++) <li>
                                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                    </li>
                                                    @endfor
                                            </ul>
                                            <h5>
                                                {{ $review->userData->name }},
                                                <span>{{ $review->created_at->format('d M, Y . h:i a') }}</span>
                                            </h5>
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @if (Auth::check())
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="comment-box">
                        <h3>Add Your Comments</h3>
                        <form id="contact_form" action="{{ route('review_rating') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <textarea name="review" class="form-control required" rows="3"
                                    placeholder="Enter Message"></textarea>
                            </div>
                            <div class="review-box clearfix">
                                <p>Your Review</p>
                                <ul class="rating clearfix" id="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++) <li data-value="{{ $i }}"><i class="far fa-star"></i>
                                        </li>
                                        @endfor
                                </ul>
                                <input type="hidden" name="rating" id="rating-value" value="0">
                            </div>
                            <div class="mb-2 mt-2">
                                <button type="submit" class="theme-btn btn-style-one">
                                    <span class="btn-title">Submit Comment</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
        <div class="text divide" id="faq">
            <div class="row faq-card">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>Frequently Asked Questions</h1>
                    </div>
                </div>
                <div class="col-lg-12 card">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How will I benefit from having a priest perform the puja?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>pujariji</strong> is a reliable online platform where you can
                                    participate in pujas conducted at renowned temples and pilgrimage sites
                                    across the country, all from the comfort of your home. The puja you
                                    participate in is performed by priests at an auspicious time. After the
                                    puja, the prasad is delivered to the address you provided within the
                                    designated time.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    What if I don't know my Gotra? Can I still perform the puja?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Yes, absolutely. If you don't know your Gotra, simply enter "Kashyap Gotra"
                                    when booking the puja. This is because all of us are descendants of the sage
                                    Kashyap.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How will the puja I booked be performed?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    The puja will be performed by learned scholars and priests at the designated
                                    location through <strong> Pujariji's</strong> platform. During the puja, the
                                    priest will chant your name and Gotra during the Sankalp (invocation) and
                                    complete the ritual.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    How will I know that the puja was performed in my name?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    After the puja is completed, a video of the chanting of your name and Gotra
                                    will be shared with you.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Is physical presence required for the puja, or can I book it online?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Not at all. You can mentally participate by booking the puja online. In both
                                    offline and online pujas, the priest will perform the Sankalp by chanting
                                    your name and Gotra and will complete the ritual. In an offline puja, you
                                    perform the rituals at your home, while in an online puja, all the
                                    facilities are provided to you at your home.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    What other services does <strong>Pujariji</strong> provide?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Through <strong> Pujariji </strong>, you can invite a priest to your home
                                    with all the necessary materials to perform rituals such as Havan, Abhishek,
                                    Ganesh Puja, Mahamrityunjaya Japa, and other ceremonies.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    I live with many people outside my home and lack a proper place for puja.
                                    Can I still book a puja through <strong> Pujariji</strong>?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Yes, absolutely. <strong>Pujariji</strong> allows you to book any puja
                                    online and participate mentally via video call, with the priest performing
                                    the rituals personally for you.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    Does <strong> Pujariji </strong> also perform pujas at pilgrimage sites?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Yes, <strong> Pujariji </strong> conducts pujas at renowned pilgrimage sites
                                    in India either through online mediums or by visiting the sites in person.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    Where can I contact for more information?
                                </button>
                            </h2>
                            <div id="collapseNine" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    For more information, please contact at this number: 8932980098.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        <ul class="page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">होम</a></li>
            <li class="breadcrumb-item"><a href="{{ route('one-day-puja') }}">ई-पूजा</a></li>
            <li class="breadcrumb-item">{{ $product->name_hindi }}</li>
        </ul>
    </div>
</div>
<section class="product-details mb-4">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-5">
                <div class="swiper product_slider">
                    <div class="swiper-wrapper">
                        @if (isset($product->photos))
                        @foreach ($product->photos as $product_image)
                        <div class="swiper-slide">
                            <img src="{{ uploaded_asset($product_image) }}" alt="image"
                                onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                        </div>
                        @endforeach
                        @else
                        <img src="{{ asset('frontend/pujari/placeholder.jpeg') }}" alt="image">
                        @endif
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="product_info_pujari product-info">
                    <div class="product-details__top">
                        <h3 class="product-details__title">{{ $product->name_hindi }}</h3>
                        <div class="product-details__content">
                            {!! $product->short_description_hindi !!}
                        </div>
                        <p class="mb-0">
                            <img src="{{asset('frontend/assets/images/temple_venue.svg')}}" class="wh-20">
                            :
                            @if (isset($temple_detail->title_hindi))
                            <span>{{ $temple_detail->title_hindi }}</span>
                            @endif
                        </p>
                        <p class="mb-0">
                            <img src="{{asset('frontend/assets/images/date.svg')}}" class="wh-20"> :
                            <span>{{ \Carbon\Carbon::parse($product->date)->format('l, j F Y') }},
                                {{ $product->tithi_hindi }}</span>
                        </p>
                    </div>
                    <div class="pooja-at">
                        <div class="row">
                            <div class="col-md-6">
                                <b>पूजा की बुकिंग बंद हो जाएगी ::</b>
                                <div id="countdown" class="d-flex relative w-full mt-2">
                                    <ul class="d-flex w-full justify-content-between flex-1">
                                        <li class="timer"><span id="days"></span> <sub>Days</sub></li>
                                        <li class="timer"><span id="hours"></span> <sub>Hours</sub></li>
                                        <li class="timer"><span id="minutes"></span> <sub>Minutes</sub></li>
                                        <li class="timer"><span id="seconds"></span> <sub>Seconds</sub></li>
                                    </ul>
                                </div>
                                <div id="content" style="display: none;">
                                    <h2 style="color:red;">Booking Closed</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rating">
                                <p class="color-or"><i class="fa-solid fa-star"></i> 4.9 (7K+ ratings) </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <p>
                                अब तक <strong class="text-danger">{{ $product->fake_devote }}+
                                </strong> से अधिक भक्त पुजारी जी की इस पूजा को बुक कर चुके हैं।
                            </p>
                        </div>
                    </div>
                    <div class="product-details__buttons-1 pujari_pooja_btn mt-auto" id="package_button">
                        <a href="#packages">
                            <span class="theme-btn btn-style-one w-100">पूजा पैकेज चुनें
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="product-nav">
    <ul class="nav d-flex justify-content-between align-items-center">
        <li class="nav-item">
            <a class="nav-link active" id="about-link" href="#about">पूजा के बारे में</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="benefits-link" href="#benefits">लाभ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="process-link" href="#process">प्रक्रिया</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="temple-details-link" href="#temple_details">मंदिर का विवरण</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="packages-link" href="#packages">पैकेज</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="review-link" href="#review">समीक्षा</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="faq-link" href="#faq">अक्सर पूछे जाने वाले प्रश्न</a>
        </li>
    </ul>
</div>
<section class="product-description">
    <div class="auto-container">
        <div class="text divide" id="about">
            <div class="row">
                <div class="col-lg-12">
                    {!! $product->description_hindi !!}
                </div>
            </div>
        </div>
        <div class="text divide" id="benefits">
            <div class="row">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>लाभ</h1>
                    </div>
                </div>
                @foreach ($puja_benifit as $benefit)
                <div class="col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="title text-danger">
                                <img src="{{ asset('frontend/icons/s-icon.png') }}" style="width: 25px;">
                                {{ $benefit->title_hindi }}
                            </h5>
                            {!! $benefit->description_hindi !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="text-1 divide" id="process">
            <div class="row">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>पूजा प्रक्रिया</h1>
                    </div>
                </div>
                <div class="pooja-process-scroll">
                    <div class="row flex-nowrap pooja-process-new">
                        <div class="col">
                            <div class="arrow-card">
                                <span class="arrow-heading">1</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600">उपासना
                                            पैकेज चुनें</h3>
                                    </div>
                                    <p class="card-text font_black_14">अपनी आवश्यकताओं के आधार पर पूजा और पैकेज
                                        चुनें, जैसे व्यक्तिगत, युगल या पारिवारिक पूजा।</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="arrow-card">
                                <span class="arrow-heading">2</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600"> अर्पण
                                            जोड़ें</h3>
                                    </div>
                                    <p class="card-text font_black_14">अपनी पूजा के साथ-साथ गौ सेवा, दीप दान,
                                        वस्त्र दान, अन्न दान, ब्राह्मण तर्पण जैसे अतिरिक्त विकल्प भी चुनें।</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="arrow-card">
                                <span class="arrow-heading">3</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600"> संकल्प
                                            विवरण भरे</h3>
                                    </div>
                                    <p class="card-text font_black_14">चुने गए पूजा के आधार पर अपना नाम, वंश
                                        (गोत्र) और पता (यदि लागू हो) के साथ संकल्प फॉर्म भरें।</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="arrow-card">
                                <span class="arrow-heading">4</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600"> पूर्ण
                                            भुगतान</h3>
                                    </div>
                                    <p class="card-text font_black_14">चयनित पूजा में अपनी भागीदारी की पुष्टि करने
                                        के लिए भुगतान करें। अपने पंजीकृत व्हाट्सएप नंबर पर पूजा के वास्तविक समय के
                                        अपडेट प्राप्त करें।</p>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="arrow-card">
                                <span class="arrow-heading">5</span>
                            </div>
                            <div class="card puja-process-card">
                                <div class="card-body puja-card-body">
                                    <div class="d-flex align-items-center mb-3 h-55">
                                        <span class="arrow-num">
                                            <span class="arrow-num">
                                                <img src="{{ asset('frontend/icons/s-icon.png') }}" class="img-fluid">
                                            </span>
                                        </span>
                                        <h3 class="card-title font_black_16 pb-2 font-poppins font-600">पूजा प्रसाद
                                            एवं वीडियो</h3>
                                    </div>
                                    <p class="card-text font_black_14">आपके नाम और वंश के साथ की गई पूजा का एक
                                        वीडियो 3-4 दिनों के भीतर आपके साथ साझा किया जाएगा और यह आपकी प्रोफ़ाइल पर भी
                                        उपलब्ध होगा। प्रसाद 8-10 दिनों के भीतर दिए गए पते पर भेज दिया जाएगा।</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text divide mt-4" id="temple_details">
            <div class="row">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1 class="text-dark">मंदिर का विवरण</h1>
                    </div>
                </div>
            </div>
            @if (!empty($temple_detail->id))
            <div class="row px-2">
                <div class="col-lg-4">
                    <figure class="image-box">
                        <img src="{{ uploaded_asset($temple_detail->image) }}" alt="image" class="rounded-3"
                            onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                    </figure>
                </div>
                <div class="col-lg-8 mt-4">
                    <h4 class="text-dark">{{ $temple_detail->title_hindi }}</h4>
                    <div class="desc">{!! $temple_detail->description_hindi !!}</div>
                    <button class="read-more-btn">Read More</button>
                </div>
            </div>
            @endif
        </div>
        <div id="test"></div>
        <div class="text divide" id="packages">
            <div class="row">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>पूजा पैकेज चुनें</h1>
                    </div>
                </div>
                <div class="col-sm-12 d-block d-sm-none">
                    <div class="all_packages">
                        <div class="packages-wrapper">
                            @foreach ($package_list as $index => $package_data)
                            <div class="package-card" data-package-id="{{ $package_data->id }}"
                                onclick="showPackage({{ $package_data->id }})">
                                <p class="package-name">{{ $package_data->package_name_hindi }}</p>
                                <div class="pack-money">
                                    <small class="package-price">₹ {{ $package_data->discount_price }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="package-slider">
                    <div class="row gy-4 justify-content-center">
                        @foreach ($package_list as $index => $package_data)
                        <div class="col-lg-3 col-md-6 package-content" id="package-{{ $package_data->id }}">
                            <div class="card puja-card">
                                <div class="card-body">
                                    <div class="card-img">
                                        <img src="{{ uploaded_asset($package_data->image) }}"
                                            onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                                    </div>
                                    <h6 class="card-title mt-1">
                                        <a href="{{ route('one_day_product_package', $package_data->id) }}">
                                            {{ $package_data->package_name_hindi }} (व्यक्ति:
                                            {{ $package_data->no_of_people }})
                                        </a>
                                    </h6>
                                    <div class="price">
                                        <h5 class="text-center">₹ {{ $package_data->discount_price }}</h5>
                                    </div>
                                    <div class="description short">{!! $package_data->description_hindi !!}</div>
                                    <button class="read-more-btn">और पढ़ें</button>
                                    <div class="content">
                                        <a href="{{ route('one_day_product_package', $package_data->id) }}"
                                            class="theme-btn btn-style-one read-more w-100">
                                            {{-- भाग लें --}}
                                            SELECT PACKAGE
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if ($review_list->count() > 0)
        <div class="customer-comment text product-discription divide" id="review">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>समीक्षा</h1>
                    </div>
                </div>
                <div class="carousel-outer">
                    <div class="swiper review-slider">
                        <div class="swiper-wrapper">
                            @foreach ($review_list as $review)
                            <div class="swiper-slide">
                                <div class="single-comment-box">
                                    <div class="inner-box">
                                        <figure class="comment-thumb">
                                            <img src="{{ $review->userData->profile_picture }}" alt="img"
                                                onerror="this.src='{{ asset('frontend/assets/images/customer.png') }}';">
                                        </figure>
                                        <div class="inner">
                                            <ul class="rating clearfix">
                                                @for ($i = 1; $i <= 5; $i++) <li>
                                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                    </li>
                                                    @endfor
                                            </ul>
                                            <h5>
                                                {{ $review->userData->name }},
                                                <span>{{ $review->created_at->format('d M, Y . h:i a') }}</span>
                                            </h5>
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @if (Auth::check())
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="comment-box">
                        <h3>Add Your Comments</h3>
                        <form id="contact_form" action="{{ route('review_rating') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <textarea name="review" class="form-control required" rows="3"
                                    placeholder="Enter Message"></textarea>
                            </div>
                            <div class="review-box clearfix">
                                <p>Your Review</p>
                                <ul class="rating clearfix" id="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++) <li data-value="{{ $i }}"><i class="far fa-star"></i>
                                        </li>
                                        @endfor
                                </ul>
                                <input type="hidden" name="rating" id="rating-value" value="0">
                            </div>
                            <div class="mb-2 mt-2">
                                <button type="submit" class="theme-btn btn-style-one">
                                    <span class="btn-title">Submit Comment</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
        <div class="text divide" id="faq">
            <div class="row faq-card">
                <div class="col-lg-12">
                    <div class="three title">
                        <h1>अक्सर पूछे जाने वाले प्रश्नों</h1>
                    </div>
                </div>
                <div class="col-lg-12 card">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    पुजारी द्वारा पूजा करवाने से मुझे क्या लाभ होगा?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong> पुजारी जी </strong> एक विश्वसनीय ऑनलाइन प्लेटफ़ॉर्म है जहाँ आप देश भर
                                    के
                                    प्रसिद्ध मंदिरों और तीर्थ स्थलों पर आयोजित पूजा में भाग ले सकते हैं, वह भी अपने
                                    घर बैठे। आप जिस पूजा में भाग लेते हैं, वह पुजारी द्वारा शुभ समय पर की जाती है।
                                    पूजा के बाद, प्रसाद निर्धारित समय के भीतर आपके द्वारा दिए गए पते पर पहुँचा दिया
                                    जाता है।
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    अगर मुझे अपना गोत्र नहीं पता तो क्या मैं फिर भी पूजा कर सकता हूँ?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    हां, बिल्कुल। अगर आपको अपना गोत्र नहीं पता है, तो पूजा बुक करते समय बस "कश्यप
                                    गोत्र" दर्ज करें। ऐसा इसलिए है क्योंकि हम सभी ऋषि कश्यप के वंशज हैं।
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    मैंने जो पूजा बुक की है वह कैसे होगी?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    पूजा <strong> पुजारी जी </strong> के मंच के माध्यम से निर्दिष्ट स्थान पर विद्वान
                                    पंडितों और
                                    पुजारियों द्वारा की जाएगी । पूजा के दौरान, पुजारी संकल्प (आह्वाहन) के दौरान आपका
                                    नाम और गोत्र का उच्चारण करेंगे और अनुष्ठान पूरा करेंगे।
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    मुझे कैसे पता चलेगा कि पूजा मेरे नाम पर की गई थी?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    पूजा पूरी होने के बाद आपके नाम और गोत्र के जाप का एक वीडियो आपके साथ साझा किया
                                    जाएगा।
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    क्या पूजा के लिए भौतिक उपस्थिति आवश्यक है, या मैं इसे ऑनलाइन बुक कर सकता हूं?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    बिल्कुल नहीं। आप ऑनलाइन पूजा बुक करके मानसिक रूप से भाग ले सकते हैं। ऑफ़लाइन और
                                    ऑनलाइन दोनों ही पूजाओं में पुजारी आपका नाम और गोत्र बोलकर संकल्प लेंगे और
                                    अनुष्ठान पूरा करेंगे। ऑफ़लाइन पूजा में आप अपने घर पर ही अनुष्ठान करते हैं, जबकि
                                    ऑनलाइन पूजा में आपको घर पर ही सारी सुविधाएँ मुहैया कराई जाती हैं।
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    अन्य सेवाएं क्या हैं?
                                    <strong> पुजारी जी </strong>
                                    उपलब्ध करवाना?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong> पुजारी जी </strong> के माध्यम से , आप हवन, अभिषेक, गणेश पूजा,
                                    महामृत्युंजय जप और अन्य
                                    समारोहों जैसे अनुष्ठानों के लिए सभी आवश्यक सामग्रियों के साथ एक पुजारी को अपने
                                    घर आमंत्रित कर सकते हैं।
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    मैं अपने घर के बाहर कई लोगों के साथ रहता हूँ और मेरे पास पूजा के लिए उचित स्थान
                                    नहीं है। क्या मैं फिर भी पूजा बुक कर सकता हूँ?
                                    <strong> पुजारी जी </strong>
                                    ?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    हां, बिल्कुल। <strong> पुजारी जी </strong> आपको किसी भी पूजा को ऑनलाइन बुक करने
                                    और वीडियो कॉल के
                                    माध्यम से मानसिक रूप से भाग लेने की अनुमति देते हैं, जिसमें पुजारी आपके लिए
                                    व्यक्तिगत रूप से अनुष्ठान करते हैं।
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    करता है
                                    <strong> पुजारी जी </strong>
                                    क्या आप तीर्थ स्थलों पर पूजा भी करते हैं?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    जी हां, <strong> पुजारी जी </strong> भारत के प्रसिद्ध तीर्थ स्थलों पर या तो
                                    ऑनलाइन माध्यम से या
                                    व्यक्तिगत रूप से वहां जाकर पूजा-अर्चना करते हैं।
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    अधिक जानकारी के लिए मैं कहां संपर्क कर सकता हूं?
                                </button>
                            </h2>
                            <div id="collapseNine" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    अधिक जानकारी के लिए कृपया इस नंबर पर संपर्क करें: 8932980098.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Modal -->
@if (session()->get('pooja_language') == 'English')
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row">
                    <div class="col-lg-8 col-8">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-arrow-left me-4"></i> Fill
                            your details for Puja</h5>
                    </div>
                    <div class="col-lg-4 col-4 text-end">
                        <button type="button" class="close text-dark" onclick="close_enquiry_modal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input class="input-field form-control" type="hidden" placeholder="Enter Number" name="package_id"
                        id="package_id">
                    <div class="col-md-12">
                        <label class="text-dark fw-bold">Enter Your Whatsapp Mobile Number</label>
                        <div class="input-container">
                            <i class="fa fa-phone icon-form"></i>
                            <input class="input-field form-control" type="number" id="phone" placeholder="Enter Number"
                                name="phone">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-dark fw-bold">Enter Your Name</label>
                        <div class="input-container">
                            <i class="fa fa-user icon-form"></i>
                            <input class="input-field form-control" type="text" placeholder="Enter Name" id="name"
                                name="name">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="save_enquiry_data()" class="theme-btn btn-style-one read-more w-100">Save
                    Next</button>
            </div>
        </div>
    </div>
</div>
@else
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row">
                    <div class="col-lg-8 col-8">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-arrow-left me-4"></i>
                            पूजा के लिए अपने विवरण भरें</h5>
                    </div>
                    <div class="col-lg-4 col-4 text-end">
                        <button type="button" class="close text-dark" onclick="close_enquiry_modal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input class="input-field form-control" type="hidden" placeholder="नंबर दर्ज करें" name="package_id"
                        id="package_id">
                    <div class="col-md-12">
                        <label class="text-dark fw-bold">अपना व्हाट्सएप मोबाइल नंबर दर्ज करें</label>
                        <div class="input-container">
                            <i class="fa fa-phone icon-form"></i>
                            <input class="input-field form-control" type="number" id="phone"
                                placeholder="नंबर दर्ज करें" name="phone">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-dark fw-bold">अपना नाम दर्ज करें</label>
                        <div class="input-container">
                            <i class="fa fa-user icon-form"></i>
                            <input class="input-field form-control" type="text" placeholder="नाम दर्ज करें" id="name"
                                name="name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="save_enquiry_data()" class="theme-btn btn-style-one read-more w-100">आगे
                    बढ़ें</button>
            </div>
        </div>
    </div>
</div>
@endif
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.swiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
        }
    });
</script>
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll(".nav-link");

            navLinks.forEach(link => {
                link.addEventListener("click", function() {
                    // Remove active class from all links
                    navLinks.forEach(item => item.classList.remove("active"));

                    // Add active class to the clicked link
                    this.classList.add("active");
                });
            });
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#rating-stars li');
            const ratingInput = document.getElementById('rating-value');

            stars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    // Set the value of the hidden input
                    ratingInput.value = star.getAttribute('data-value');

                    // Update the star styles
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.querySelector('i').classList.add('fas');
                            s.querySelector('i').classList.remove('far');
                        } else {
                            s.querySelector('i').classList.add('far');
                            s.querySelector('i').classList.remove('fas');
                        }
                    });
                });
            });
        });
</script>
<script>
    function set_city() {
            var city = $('#city').val();
            $.ajax({
                url: "{{ route('set_city') }}", // Laravel route
                type: "GET",
                data: {
                    city: city,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = window.location.href;
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }

        function set_location(id) {
            var location = $('#location').val();
            $.ajax({
                url: "{{ route('set_location') }}", // Laravel route
                type: "GET",
                data: {
                    location: location,
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = window.location.href;
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }

        function set_language() {
            var pooja_language = $('#pooja_language').val();
            $.ajax({
                url: "{{ route('set_pooja_language') }}", // Laravel route
                type: "GET",
                data: {
                    pooja_language: pooja_language,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = window.location.href;
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }
</script>
<script>
    (function() {
            const second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;

            // Dynamically get the target date from the server-side variable
            const givenDate = "{{ $product->date }}"; // Injected server-side date
            const countDownDate = new Date(givenDate).getTime();

            const x = setInterval(function() {
                const now = new Date().getTime(),
                    distance = countDownDate - now;

                const daysLeft = Math.floor(distance / day),
                    hoursLeft = Math.floor((distance % day) / hour),
                    minutesLeft = Math.floor((distance % hour) / minute),
                    secondsLeft = Math.floor((distance % minute) / second);

                // Display countdown values
                document.getElementById("days").innerText = daysLeft;
                document.getElementById("hours").innerText = hoursLeft;
                document.getElementById("minutes").innerText = minutesLeft;
                document.getElementById("seconds").innerText = secondsLeft;
                console.log(distance);
                // When the countdown reaches zero, stop the interval
                if (distance <= 0) {
                    const countdown = document.getElementById("countdown");
                    if (countdown) countdown.classList.add("hidden");

                    const packageButton = document.getElementById("package_button");
                    if (packageButton) packageButton.classList.add("hidden");

                    const packageTab = document.getElementById("package_tab");
                    if (packageTab) packageTab.classList.add("hidden");

                    const content = document.getElementById("content");
                    if (content) content.style.display = "block";

                    clearInterval(x); // This assumes x is a valid interval ID set elsewhere

                }
            }, 1000); // Update every second
        })();
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
            const readMoreBtns = document.querySelectorAll(".read-more-btn");

            readMoreBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    const description = btn.previousElementSibling;

                    if (description.classList.contains("short")) {
                        description.classList.remove("short");
                        description.classList.add("full");
                        btn.textContent = "Read Less";
                    } else {
                        description.classList.remove("full");
                        description.classList.add("short");
                        btn.textContent = "Read More";
                    }
                });
            });
        });

        function open_enquiry_modal(id) {
            $('#exampleModal').modal('show');
            $('#package_id').val(id);
        }

        function close_enquiry_modal() {
            $('#exampleModal').modal('hide');
        }

        function save_enquiry_data() {
            var phone = $('#phone').val();
            var name = $('#name').val();
            var package_id = $('#package_id').val();
            $.ajax({
                url: "{{ route('save_enquiry_data') }}", // Laravel route
                type: "POST",
                data: {
                    phone: phone,
                    name: name,
                    product_id: "{{ $product->id }}",
                    package_id: package_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = "{{ route('one_day_product_package', '') }}/" + package_id;
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }
</script>
<script>
    let scrollTimeout;
        $(window).on('scroll', function() {
            clearTimeout(scrollTimeout); // Clear any previous timeout
            scrollTimeout = setTimeout(function() {
                var targetDiv = $('#test');
                var button = $('#package_button');
                var rect = targetDiv[0].getBoundingClientRect();

                if (rect.bottom <= $(window).height()) {
                    button.removeClass('pujari_pooja_btn');
                } else {
                    button.addClass('pujari_pooja_btn');
                }
            }, 50);
        });
</script>
<script>
    function showPackage(packageId) {
            // Hide all packages
            document.querySelectorAll('.package-content').forEach(el => el.style.display = 'none');
            // Show the selected package
            document.getElementById('package-' + packageId).style.display = 'block';
        }
</script>
@endpush