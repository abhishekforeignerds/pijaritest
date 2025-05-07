@extends('frontend.layouts.app')
@section('content')
<section class="temple-search">
    <div class="auto-container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="{{route('teerth_puja')}}" method="GET" class="search-form">
                    <div class="form-group">
                        <input type="search" name="search"
                            placeholder="@if(session()->get('pooja_language')=='English') Search Teerth Puja... @else  तीर्थ पूजा खोजें... @endif"
                            required="">
                        <button><i class="lnr lnr-icon-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="featured-products">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                <div class="teerth-puja-city mt-lg-0">
                    <div class="filter-list">
                        <div class="row">
                            @if ($city->isEmpty())
                            <div class="not-found">
                                {{-- <img src="{{ asset('frontend/assets/images/404.png') }}"> --}}
                                <h1>Service Not Available</h1>
                                <a href="/" class="theme-btn btn-style-one"><span class="btn-title"><i
                                            class="far fa-arrow-alt-circle-left"></i>&nbsp;Back Homepage</span></a>
                            </div>
                        </div>
                        @else
                        @foreach ($city as $data)
                        <div class="col-lg-2 col-6">
                            <div class="product-block all mix pantry fruit d-block">
                                <div class="inner-box">
                                    <div class="image">
                                        <a href="{{route('teerth_puja','city='.$data->city)}}"><img
                                                src="{{ $data->full_image_url }}"
                                                onerror="this.onerror=null;this.src='{{ asset('frontend/assets/images/city.png') }}'"></a>
                                    </div>
                                    <div class="content">
                                        <h4><a href="{{route('teerth_puja','city='.$data->city)}}">
                                                @if(session()->get('pooja_language')=='English') {{ $data->city }} @else
                                                {{ $data->city_hindi }} @endif</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@if(count($video_testimonials) > 0)
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