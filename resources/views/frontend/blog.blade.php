@extends('frontend.layouts.app')
@section('content')

@section('meta')
<title>Puajri Ji</title>
<meta name="description" content="">
<meta name="keywords" content="">
@endsection
<section class="news-section service-section-three pujariji-background">
    <div class="auto-container">
        <div class="sec-title wow fadeInUp animated animated">
            @if(session()->get('pooja_language')=='English')
            <h1>
                {{ env('APP_NAME') }} Blogs
                <span>
                    Blogs
                </span>
            </h1>
            <div class="row">
                @foreach ($blogs as $blog)
                <div class="news-block col-lg-4 col-md-6 wow fadeInUp">
                    <div class="card">
                        <div class="card-body">
                            <div class="inner-box wow fadeInLeft">
                                <div class="image-box">
                                    <figure class="image overlay-anim">
                                        <a href="{{ route('blogs', $blog->slug) }}">
                                            <img src="{{ $blog->full_image_url }}"
                                                onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/resource/news-1.jpg') }}'">
                                        </a>
                                    </figure>
                                </div>
                                <div class="content-box">
                                    <h4 class="title">{{ $blog->title }}</h4>
                                    <a href="{{ route('blogs', $blog->slug) }}" class="read-more">Read More<i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @else
            <h1>
                पुजारी जी ब्लॉग
                <span>
                    ब्लॉग
                </span>
            </h1>
            <div class="row">
                @foreach ($blogs as $blog)
                <div class="news-block col-lg-4 col-md-6 wow fadeInUp">
                    <div class="card">
                        <div class="card-body">
                            <div class="inner-box wow fadeInLeft">
                                <div class="image-box">
                                    <figure class="image overlay-anim">
                                        <a href="{{ route('blogs', $blog->slug) }}">
                                            <img src="{{ $blog->full_image_url }}"
                                                onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/resource/news-1.jpg') }}'">
                                        </a>
                                    </figure>
                                </div>
                                <div class="content-box">
                                    <h4 class="title">{{ $blog->title_hindi }}</h4>
                                    <a href="{{ route('blogs', $blog->slug) }}" class="read-more">अधिक पढ़ें<i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @endif
        </div>

    </div>
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

@endsection