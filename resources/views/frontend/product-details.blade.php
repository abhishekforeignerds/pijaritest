@extends('frontend.layouts.app')

@section('meta')
<title>
    {{ $product->meta_title ?: $product->name }}</title>
<meta name="description" content="{{ $product->meta_description ?: $product->name }}">
<meta name="keywords" content="{{ $product->meta_keywords ?: $product->name }}">
@endsection

@section('content')

@if (session()->get('pooja_language') == 'English')
<div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        <ul class="page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            @if ($product->product_type == 'all')
            <li class="breadcrumb-item"><a href="{{ route('puja') }}">Puja</a></li>
            @else
            <li class="breadcrumb-item"><a href="{{ route('teerth-puja-city') }}">Teerth Puja</a></li>
            @endif
            <li class="breadcrumb-item">{{ $product->name }}</li>
        </ul>
    </div>
</div>
@php
// current page URL
$shareUrl = url()->current();
// optional: include a custom message
$message = "Check out this Puja: Book now:";
// full text for WhatsApp
$whatsAppText = urlencode($message . " " . $shareUrl);
@endphp
<section class="product-details">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-5 col-12">
                <figure class="image-box">
                    <img src="{{ $product->full_image_url }}" alt="image"
                        onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                </figure>
            </div>

            <div class="col-lg-7 col-12 product-info">
                <div class="product-details__top">
                    <h3 class="product-details__title">{{ $product->name }}
                    </h3>
                    @if ($maxPrice > $minPrice)
                    <h6><span><strong>Price :</strong> ₹{{ $minPrice }} - ₹{{ $maxPrice }}</span>
                    </h6>
                    @else
                    <h6><span><strong>Price :</strong> ₹{{ $minPrice }} </span> </h6>
                    @endif
                </div>
                {{-- <div class="col-md-4">
                    <select class="form-control" name="pooja_language" id="pooja_language" onchange="set_language()">
                        <option value="english" @if (session()->get('pooja_language') == 'english') selected @endif
                            >English</option>
                        <option value="hindi" @if (session()->get('pooja_language') == 'hindi') selected @endif >Hindi
                        </option>
                    </select>
                </div> --}}
                <div class="product-details__content">
                    {!! $product->short_description !!}
                    {{-- <div class="promise"> --}}
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <h5>Key Insights</h5>
                                {!! $product->key_insight !!}
                            </div>
                            <div class="col-md-12">
                                <h5>Our Promise</h5>
                                {!! $product->promise !!}
                            </div>

                        </div> --}}
                        {{-- </div> --}}
                </div>
                <div class="pooja-at form-fixed">
                    <div class="row">
                        {{-- <div class="col-md-6">
                            <b>Pooja Performed in : {{ session()->get('city') }}</b>
                        </div> --}}
                        <div class="col-md-6">
                        </div>
                        @if ($product->product_type == 'all')
                        {{-- <div class="col-md-4 col-4 mb-4">
                            <select id="location" name="location" class="select-input-form w-100"
                                style="border: 1px solid #dddddd;" onchange="set_location('{{ $product->id }}')">
                                <option value="">Select Location</option>
                                @if ($product->location_type == 'both')
                                <option value="home" @if (session()->get('user_location') == 'home') selected @endif>
                                    At My Home</option>
                                <option value="online" @if (session()->get('user_location') == 'online') selected
                                    @endif>
                                    Online</option>
                                @endif
                                @if ($product->location_type == 'offline')
                                <option value="home" @if (session()->get('user_location') == 'home') selected @endif>
                                    At My Home</option>
                                @endif
                                @if ($product->location_type == 'online')
                                <option value="online" @if (session()->get('user_location') == 'online') selected
                                    @endif>
                                    Online</option>
                                @endif
                            </select>
                        </div> --}}
                        @if (session()->get('user_location') != 'online')
                        {{-- <div class="col-md-4 col-4 mb-4">
                            <select id="city" name="city" class="select-input-form js-example-basic-single w-100"
                                data-live-search="true" onchange="set_city_detail()">
                                <option value="">Select City</option>
                                @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                <option value="{{ $city->city }}" @if (session()->get('city') == $city->city) selected
                                    @endif>
                                    {{ $city->city }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        @endif
                        {{-- <div class="col-md-4 col-4 mb-4">
                            <select id="language" name="language"
                                class="select-input-form js-example-basic-single w-100"
                                onchange="set_language_detail()">
                                <option value="">Select Language</option>
                                @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                <option value="{{ $language->language }}" @if (session()->get('language') ==
                                    $language->language) selected @endif>
                                    {{ $language->language }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}
                        @endif
                        @if ($product->product_type == 'temple')
                        {{-- <div class="col-md-4 col-12 mb-4">
                            <select id="location" name="location" class="select-input-form w-100"
                                style="border: 1px solid #dddddd;" onchange="set_location('{{ $product->id }}')">
                                <option value="">Select Location</option>
                                @if ($product->location_type == 'both')
                                <option value="at_location" @if (session()->get('user_location') == 'at_location')
                                    selected @endif>At Location</option>
                                <option value="online" @if (session()->get('user_location') == 'online') selected
                                    @endif>
                                    Online</option>
                                @endif
                                @if ($product->location_type == 'offline')
                                <option value="at_location" @if (session()->get('user_location') == 'at_location')
                                    selected @endif>At Location</option>
                                @endif
                                @if ($product->location_type == 'online')
                                <option value="online" @if (session()->get('user_location') == 'online') selected
                                    @endif>
                                    Online</option>
                                @endif
                            </select>
                        </div> --}}
                        @endif
                    </div>
                </div>
                @if ($product->product_type != 'temple')
                @php
                $language = App\Models\Language::where('language', session()->get('language'))->first();
                $city = App\Models\ServiceCity::where('city', session()->get('city'))->first();
                if (!empty($language->id) && !empty($language->id)) {
                $pujari = App\Models\Pujari::whereJsonContains(
                'language',
                '' . $language->id,
                )->get();
                } else {
                $pujari = [];
                }
                @endphp
                {{-- <div class="col-12 mb-3">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            Pooja Benefits
                        </div>
                        <div class="card-body">
                            {!! $product->key_insight !!}
                        </div>
                    </div>
                </div> --}}
                <div class="col-12 mb-3">
                    <div class="">
                        <h4 class="">
                            Pooja Benefits
                        </h4>
                        <div class="">
                            {!! $product->key_insight !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if (count($pujari) > 0)
                    @if (!empty(session()->get('user_location')) && !empty(session()->get('city')))

                    <div class="product-details__buttons col-md-12 text-end mt-4 d-flex">
                        <!-- Pricing & Packages Button -->
                        <div class="col-md-6 mb-2 mb-md-0">
                            <div class="product-details__buttons-1 button-fixed">
                                <a href="#pricing-packages" class="theme-btn btn-style-one w-100">
                                    <span class="btn-title">
                                        View Pricing and <i class="far fa-long-arrow-alt-right"></i>
                                    </span>
                                </a>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="product-details__buttons-1 button-fixed">
                                <a href="https://api.whatsapp.com/send?text={{ $whatsAppText }}" target="_blank"
                                    rel="noopener"
                                    class="btn btn-success d-inline-flex align-items-center justify-content-center py-2 px-3 w-100">
                                    <i class="fab fa-whatsapp fa-lg me-2"></i>
                                    @if(session('pooja_language')=='English')
                                    Share on WhatsApp
                                    @else
                                    WhatsApp पर साझा करें
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="product-details__buttons col-lg-6 col-md-12 text-end mt-4">
                        <div class="product-details__buttons-1 button-fixed">
                            <a href="#pricing-packages" class="theme-btn btn-style-one">
                                <span class="btn-title"> View
                                    Pricing and
                                    Packages <i class="far fa-long-arrow-alt-right"></i></span></a>
                        </div>
                    </div>
                    {{-- <div class="product-details__buttons col-lg-6 col-md-12 text-end mt-4">
                        <div class="product-details__buttons-1 button-fixed">
                            <button type="button" class="theme-btn btn-style-one w-100">
                                <span class="btn-title" onclick="show_alert_english()">
                                    Please Select City,Language and Location
                                    <i class="far fa-long-arrow-alt-right"></i>
                                </span>
                            </button>
                        </div>
                    </div> --}}
                    @endif
                    @else
                    {{-- <div class="mt-4">
                        <div class="product-details__buttons">
                            <div class="product-details__buttons-1 button-fixed">
                                <p class="theme-btn btn-style-one w-100 disabled" onclick="show_alert_english()">
                                    Please Select
                                    City,Language
                                    and Location.</p>
                            </div>
                        </div>
                    </div> --}}
                    <div class="product-details__buttons col-lg-6 col-md-12 text-end mt-4">
                        <div class="product-details__buttons-1 button-fixed">
                            {{-- <a href="{{ route('product_package', $product->slug) }}"
                                class="theme-btn btn-style-one">
                                --}}
                                <a href="#pricing-packages" class="theme-btn btn-style-one">
                                    <span class="btn-title"> View Pricing and
                                        Packages <i class="far fa-long-arrow-alt-right"></i></span></a>
                        </div>
                    </div>
                    <div class="product-details__buttons col-lg-6 col-md-12 text-end mt-4">
                        <div class="product-details__buttons-1 button-fixed">
                            <a href="https://api.whatsapp.com/send?text={{ $whatsAppText }}" target="_blank"
                                rel="noopener"
                                class="btn btn-success d-inline-flex align-items-center justify-content-center py-2 px-3"
                                style="width:100%;">
                                <i class="fab fa-whatsapp fa-lg me-2"></i>
                                @if(session('pooja_language')=='English')
                                Share on WhatsApp
                                @else
                                WhatsApp पर साझा करें
                                @endif
                            </a>
                        </div>
                    </div>
                    @endif
                    @else
                    @if (!empty(session()->get('user_location')))
                    <div class="product-details__buttons col-lg-6 col-md-12 text-end mt-4">
                        <div class="product-details__buttons-1 button-fixed">
                            <a href="#pricing-packages" class="theme-btn btn-style-one">
                                class="theme-btn btn-style-one w-100"><span class="btn-title"> View Pricing and
                                    Packages <i class="far fa-long-arrow-alt-right"></i></span>
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="product-details__buttons col-lg-6 col-md-12 text-end mt-4">
                        <div class="product-details__buttons-1 button-fixed">
                            <a href="#pricing-packages" class="theme-btn btn-style-one">
                                class="theme-btn btn-style-one w-100"><span class="btn-title"> View Pricing and
                                    Packages <i class="far fa-long-arrow-alt-right"></i></span>
                            </a>
                        </div>
                    </div>
                    {{--
                    <div class="mt-4">
                        <div class="product-details__buttons">
                            <div class="product-details__buttons-1 button-fixed">
                                <p class="theme-btn btn-style-one w-100 disabled" onclick="show_alert_english()">
                                    Please Select Location.</p>
                            </div>
                        </div>
                    </div> --}}
                    @endif
                    @endif
                </div>
            </div>


        </div>
    </div>
</section>
@include('frontend.product-package')
<section class="product-description">
    <!-- NAV with only three items -->
    <style>
        /* ensure full height sidebar if desired */
        .product-nav {
            height: 100%;
        }
    </style>

    <div class="container-fluid">
        <div class="row m-5">
            <!-- CONTENT COLUMN (FULL WIDTH) -->
            <div class="col-md-12">
                <!-- DESCRIPTION -->
                <div class="product-section mb-5">
                    <h2 class="three title text-center">Description</h2>
                    <div class="text-left">
                        {!! $product->description !!}
                    </div>
                </div>

                <!-- TESTIMONIALS -->
                <div class="product-section mb-5">
                    <h2 class="three title text-center">Testimonials</h2>
                    @if($review_list->count())
                    <div class="swiper review-slider">
                        <div class="swiper-wrapper">
                            @foreach($review_list as $review)
                            <div class="swiper-slide">
                                <div class="single-comment-box">
                                    <figure class="comment-thumb">
                                        <img src="{{ $review->userData->profile_picture }}"
                                            onerror="this.src='{{ asset('frontend/assets/images/customer.png') }}'">
                                    </figure>
                                    <div>
                                        <ul class="rating clearfix">
                                            @for($i = 1; $i <= 5; $i++) <li><i
                                                    class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                </li>
                                                @endfor
                                        </ul>
                                        <h5>{{ $review->userData->name }},
                                            <span>{{ $review->created_at->format('d M, Y . h:i a') }}</span>
                                        </h5>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    @if(Auth::check())
                    <div class="comment-box mt-4">
                        <h3>Add Your Comments</h3>
                        <form action="{{ route('review_rating') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <textarea name="review" class="form-control" rows="3"
                                placeholder="Enter Message"></textarea>
                            <div class="review-box clearfix mt-3">
                                <p>Your Review</p>
                                <ul class="rating clearfix" id="rating-stars">
                                    @for($i=1;$i<=5;$i++) <li data-value="{{ $i }}"><i class="far fa-star"></i></li>
                                        @endfor
                                </ul>
                                <input type="hidden" name="rating" id="rating-value" value="0">
                            </div>
                            <button type="submit" class="theme-btn btn-style-one mt-3">
                                <span class="btn-title">Submit Comment</span>
                            </button>
                        </form>
                    </div>
                    @endif
                    @else
                    <h2 class="three title text-center my-3">No Testimonials Found</h2>
                    @endif
                </div>

                <!-- FAQ -->
                <div class="product-section mb-5">
                    <h2 class="three title">Frequently Asked Questions</h2>
                    <div class="accordion" id="accordionExample">
                        {!! $product->faq !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="auto-container tab-content">


        <div class="col-12 mb-3">
            <div class="card border-secondary">
                <div class="card-header bg-secondary text-white">
                    Our Promise
                </div>
                <div class="card-body">
                    {!! $product->promise !!}
                </div>
            </div>
        </div>
    </div>

</section>




<script>
    // activate Bootstrap tabs (requires Bootstrap JS)
  document.querySelectorAll('.product-nav .nav-link').forEach(tab=>{
    tab.addEventListener('click', e=>{
      e.preventDefault();
      // remove active classes
      document.querySelectorAll('.product-nav .nav-link').forEach(a=>a.classList.remove('active'));
      document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('show','active'));
      // activate this tab + pane
      tab.classList.add('active');
      document.querySelector(tab.getAttribute('href')).classList.add('show','active');
    });
  });
</script>

@else
<div class="breadcrumb_sticky">
    <div class="container-fluid p-0">
        <ul class="page-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">होम</a></li>
            @if ($product->product_type == 'all')
            <li class="breadcrumb-item"><a href="{{ route('puja') }}">पूजा</a></li>
            @else
            <li class="breadcrumb-item"><a href="{{ route('teerth-puja-city') }}">तीर्थ पूजा</a></li>
            @endif
            <li class="breadcrumb-item">{{ $product->name_hindi }}</li>
        </ul>
    </div>
</div>

@php
// वर्तमान पृष्ठ URL
$shareUrl = url()->current();
// WhatsApp के लिए संदेश (हिंदी)
$message = "इस पूजा को देखें: अभी बुक करें:";
$whatsAppText = urlencode($message . " " . $shareUrl);
@endphp

<section class="product-details">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-5 col-12">
                <figure class="image-box">
                    <img src="{{ $product->full_image_url }}" alt="image"
                        onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                </figure>
            </div>
            <div class="col-lg-7 col-12 product-info">
                <div class="product-details__top">
                    <h3 class="product-details__title">{{ $product->name_hindi }}</h3>
                    @if ($maxPrice > $minPrice)
                    <h6><span><strong>मूल्य :</strong> ₹{{ $minPrice }} - ₹{{ $maxPrice }}</span></h6>
                    @else
                    <h6><span><strong>मूल्य :</strong> ₹{{ $minPrice }}</span></h6>
                    @endif
                </div>
                <div class="product-details__content">
                    {!! $product->short_description_hindi !!}
                </div>

                <div class="product-details__buttons col-lg-6 col-md-12 text-end mt-4">
                    <div class="product-details__buttons-1 button-fixed">
                        <a href="#pricing-packages" class="theme-btn btn-style-one">
                            <span class="btn-title">मूल्य और पैकेज देखें <i
                                    class="far fa-long-arrow-alt-right"></i></span>
                        </a>
                    </div>
                </div>

                <div class="product-details__buttons col-lg-6 col-md-12 text-end mt-2">
                    <div class="product-details__buttons-1 button-fixed">
                        <a href="https://api.whatsapp.com/send?text={{ $whatsAppText }}" target="_blank" rel="noopener"
                            class="btn btn-success d-inline-flex align-items-center justify-content-center py-2 px-3"
                            style="width:100%;">
                            <i class="fab fa-whatsapp fa-lg me-2"></i>WhatsApp पर साझा करें
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('frontend.product-package')

<section class="product-description">
    <div class="container-fluid">
        <div class="row">
            <!-- NAV COLUMN (20%) -->
            <div class="col-md-2 product-nav">
                <ul class="nav flex-column nav-pills" id="productTab" role="tablist" aria-orientation="vertical">
                    <li class="nav-item">
                        <a class="nav-link active" id="desc-link" data-toggle="pill" href="#desc-h" role="tab">विवरण</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="testi-link" data-toggle="pill" href="#testi-h" role="tab">समीक्षाएँ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="faq-link" data-toggle="pill" href="#faq-h" role="tab">सामान्य प्रश्न</a>
                    </li>
                </ul>
            </div>
            <!-- CONTENT COLUMN (80%) -->
            <div class="col-md-10 tab-content" id="productTabContent">
                <!-- DESCRIPTION -->
                <div class="tab-pane fade show active" id="desc-h" role="tabpanel">
                    <div class="text-left">
                        {!! $product->description_hindi !!}
                    </div>
                </div>
                <!-- TESTIMONIALS -->
                <div class="tab-pane fade" id="testi-h" role="tabpanel">
                    @if($review_list->count())
                    <h2 class="three title">समीक्षाएँ</h2>
                    <div class="swiper review-slider">
                        <div class="swiper-wrapper">
                            @foreach($review_list as $review)
                            <div class="swiper-slide">
                                <div class="single-comment-box">
                                    <figure class="comment-thumb">
                                        <img src="{{ $review->userData->profile_picture }}"
                                            onerror="this.src='{{ asset('frontend/assets/images/customer.png') }}'">
                                    </figure>
                                    <div>
                                        <ul class="rating clearfix">
                                            @for($i=1;$i<=5;$i++) <li><i
                                                    class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                </li>
                                                @endfor
                                        </ul>
                                        <h5>{{ $review->userData->name }}, <span>{{ $review->created_at->format('d M, Y
                                                . h:i a') }}</span></h5>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    @if(Auth::check())
                    <div class="comment-box mt-4">
                        <h3>अपनी समीक्षा जोड़ें</h3>
                        <form action="{{ route('review_rating') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <textarea name="review" class="form-control" rows="3"
                                placeholder="अपना संदेश लिखें"></textarea>
                            <div class="review-box clearfix mt-3">
                                <p>आपकी रेटिंग</p>
                                <ul class="rating clearfix" id="rating-stars">
                                    @for($i=1;$i<=5;$i++) <li data-value="{{ $i }}"><i class="far fa-star"></i></li>
                                        @endfor
                                </ul>
                                <input type="hidden" name="rating" id="rating-value" value="0">
                            </div>
                            <button type="submit" class="theme-btn btn-style-one mt-3">
                                <span class="btn-title">समीक्षा भेजें</span>
                            </button>
                        </form>
                    </div>
                    @endif
                    @else
                    <h2 class="three title my-3">कोई समीक्षा नहीं मिली</h2>
                    @endif
                </div>
                <!-- FAQ -->
                <div class="tab-pane fade" id="faq-h" role="tabpanel">
                    <h2 class="three title">सामान्य प्रश्न</h2>
                    <div class="accordion" id="accordionExample">
                        {!! $product->faq_hindi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="auto-container tab-content">
        <div class="col-12 mb-3">
            <div class="card border-info">
                <div class="card-header bg-info text-white">मुख्य जानकारी</div>
                <div class="card-body">{!! $product->key_insight_hindi !!}</div>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="card border-info">
                <div class="card-header bg-info text-white">हमारा वादा</div>
                <div class="card-body">{!! $product->promise_hindi !!}</div>
            </div>
        </div>
    </div>
</section>

@endif
@if (session()->get('pooja_language') == 'English')
<!-- Modal -->
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

                    <div class="col-md-12">
                        <label class="text-dark fw-bold">Enter Your Whatsapp Mobile
                            Number</label>
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
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-arrow-left me-4"></i> पूजा
                            के लिए अपने विवरण भरें</h5>
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
                <button type="button" onclick="save_enquiry_data()"
                    class="theme-btn btn-style-one read-more w-100">सहेजें और जारी रखें</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@push('scripts')
<script script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function show_alert_english() {
            Swal.fire({
                icon: 'warning',
                title: 'Action Required',
                text: 'Please Select City, Language, and Location',
                confirmButtonText: 'OK',
            });
        }

        function show_alert_hindi() {
            Swal.fire({
                icon: 'warning',
                title: 'कार्यवाही आवश्यक है',
                text: 'कृपया शहर, भाषा और स्थान चुनें',
                confirmButtonText: 'ठीक है',
            });
        }
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

        function set_city_detail() {
            var city = $('#city').val();
            $.ajax({
                url: "{{ route('set_city') }}", // Laravel route
                type: "GET",
                data: {
                    city: city,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }


        function set_language_detail() {
            var language = $('#language').val();
            $.ajax({
                url: "{{ route('set_language') }}",
                type: "GET",
                data: {
                    pooja_language: language,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }

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
            $.ajax({
                url: "{{ route('save_enquiry_data') }}", // Laravel route
                type: "POST",
                data: {
                    phone: phone,
                    name: name,
                    product_id: "{{ $product->id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = "{{ route('product_package', '') }}/" + response.product.slug;
                },
                error: function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }
</script>
@endpush