@extends('frontend.layouts.app')
@section('content')

@section('meta')
<title>Puajri Ji</title>
<meta name="description" content="">
<meta name="keywords" content="">
@endsection


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0 m-0">
            @if($products->isEmpty())
            <div class="pujas">
                <img src="{{ asset('frontend/pujari/bg-img.jpg') }}" class="img-fluid" alt="No Puja Available">
            </div>
            @else
            <div id="pujaCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($products as $index => $product)
                    <div class="carousel-item @if($index === 0) active @endif" style="height: 500px;">
                        <img src="{{ $product->full_image_url }}" class="d-block w-100 h-100" style="object-fit: cover;"
                            alt="{{ $product->name_hindi }}"
                            onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                        <div class="carousel-caption d-md-block">
                            <h5 class="overlay-title">{{ $product->name_hindi }}</h5>
                            @if(optional($product->temple_detail)->title_hindi)
                            <p class="overlay-title">{{ $product->temple_detail->title_hindi }}</p>
                            @endif
                            <p class="overlay-title">
                                {{ \Carbon\Carbon::parse($product->date)->format('l, j F Y') }}
                            </p>
                            <button class="theme-primary-btn my-4">
                                <a href="{{ route('one-day-puja.details', $product->slug) }}">
                                    <span class="btn-title"> BOOK NOW </span><i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#pujaCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#pujaCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
<section class="service-section-three">
    @php

    $products = $products->sortByDesc(function($product) {
    return \Carbon\Carbon::parse($product->date);
    });


    @endphp
    @if (session()->get('pooja_language') == 'English')
    <div class="row bg-puja-card">
        <div class="col-lg-12">
            <div class="sec-title wow fadeInUp animated animated">
                <h1>
                    Welcome to Pujari ji E -Puja Services
                    <span class="phone-hide">
                        Puja Services for you and your loved ones
                    </span>
                </h1>
                <p>Get the divine experience of online Puja with personalized Puja rituals and astrological
                    insights. Book your spiritual journey now.
                </p>
            </div>
        </div>

        @foreach ($products as $product)
        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <a href="{{ route('one-day-puja.details', $product->slug) }}">
                <div class="card puja-card h-100">
                    <div class="card-body">
                        <img src="{{ $product->full_image_url }}" alt="image"
                            onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                        <h6 class="card-title">
                            <a href="{{ route('one-day-puja.details', $product->slug) }}">{{ $product->name }}</a>
                        </h6>
                        <p class="mb-0">
                            <img src="{{ asset('frontend/assets/images/temple_venue.svg') }}" class="wh-20"> :
                            @if (isset($product->temple_detail->title))
                            <span>{{ $product->temple_detail->title }}</span>
                            @endif
                        </p>
                        <p class="mb-0">
                            <img src="{{ asset('frontend/assets/images/temple_venue.svg') }}" class="wh-20"> :
                            <span>{{ \Carbon\Carbon::parse($product->date)->format('l, j F Y') }}</span>
                        </p>
                    </div>
                    <div class="content p-2">
                        <a href="{{ route('one-day-puja.details', $product->slug) }}"
                            class="theme-btn btn-style-one read-more w-100">
                            PARTICIPATE <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    </div>
    @else
    <div class="row bg-puja-card">
        <div class="col-lg-12">
            <div class="sec-title wow fadeInUp animated animated">
                <h1>
                    पुजारी जी ई-पूजा सेवाओं में आपका स्वागत है
                    <span class="phone-hide">
                        आपके और आपके प्रियजनों के लिए पूजा सेवाएँ
                    </span>
                </h1>
                <p>व्यक्तिगत पूजा अनुष्ठानों और ज्योतिषीय मार्गदर्शन के साथ ऑनलाइन पूजा का दिव्य अनुभव प्राप्त
                    करें। अपनी आध्यात्मिक यात्रा अभी बुक करें।
                </p>
            </div>
        </div>

        @foreach ($products as $product)
        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <a href="{{ route('one-day-puja.details', $product->slug) }}">
                <div class="card puja-card h-100">
                    <div class="card-body">
                        <img src="{{ $product->full_image_url }}" alt="image"
                            onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                        <h6 class="card-title">
                            <a href="{{ route('one-day-puja.details', $product->slug) }}">{{ $product->name_hindi
                                }}</a>
                        </h6>
                        <p class="mb-0">
                            <img src="{{asset('frontend/assets/images/temple_venue.svg')}}" class="wh-20"> :
                            @if (isset($product->temple_detail->title_hindi))
                            <span>{{ $product->temple_detail->title_hindi }}</span>
                            @endif
                        </p>
                        <p class="mb-0">
                            <img src="{{asset('frontend/assets/images/date.svg')}}" class="wh-20"> :
                            <span>{{ \Carbon\Carbon::parse($product->date)->format('l, j F Y') }}</span>
                        </p>
                    </div>
                    <div class="content p-2">
                        <a href="{{ route('one-day-puja.details', $product->slug) }}"
                            class="theme-btn btn-style-one read-more w-100">
                            BOOK PUJA NOW <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    </div>
    @endif
</section>
@if (count($video_testimonials) > 0)
<section class="video-testimonial-section service-section-three pujariji-background">
    <div class="auto-container">
        @if (session()->get('pooja_language') == 'English')
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                Testimonials
                <span>
                    VIDEO FEEDBACK
                </span>
            </h1>
        </div>
        @else
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                समीक्षाएं
                <span>
                    वीडियो प्रतिक्रिया
                </span>
            </h1>
        </div>
        @endif
        <div class="carousel-outer">
            <div class="swiper video-testimonial">
                <div class="swiper-wrapper">
                    @foreach ($video_testimonials as $test)
                    <div class="swiper-slide">
                        <iframe width="100%" class="ytb" src="{{ $test->link }}?modestbranding=1&controls=0"></iframe>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
</div>
@endsection