@extends('frontend.layouts.app')

@section('meta')
@if ($pagetitle)
<title>{{ $pagetitle}}</title>
@endif
@if ($pagedescription)
<meta name="description" content="{{$pagedescription}}">
@endif


<meta name="keywords" content="">
@endsection


@section('content')
<style>
    .loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Spinner style */
    .spinner {
        width: 150px;
        height: 150px;
        animation: spin 2s linear infinite;
    }

    /* Keyframes for spinner animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

{{-- <div id="loader" class="loader">
    <div class="spinner">
        <div class="d-block m-auto">
            <img src="{{asset('frontend/images/loader.png')}}">
        </div>
    </div>
</div> --}}

{{-- changed slider to pooja images --}}
{{-- <section class="banner-section carousel-outer">
    <div class="swiper banner-slider">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
            <div class="swiper-slide">
                <figure class="image">
                    <img src="{{ $slider->full_image_url }}"
                        onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/banner/banner-1.jpg') }}'">
                </figure>
            </div>
            @endforeach
        </div>
    </div>
    <button id="playGhanti" style="display:none;">Play Ghanti</button>
    <button id="playShankh" style="display:none;">Play Shankh</button>
    <button id="playDamaru" style="display:none;">Play Damaru</button>
    <audio id="ghantiSound" src="https://pujariji.com/public/ghanti.mp3"></audio>
    <audio id="shankhSound" src="https://pujariji.com/public/shankh.mp3"></audio>
    <audio id="damaruSound" src="https://pujariji.com/public/damaru.mp3"></audio>
</section> --}}
<section class="banner-section carousel-outer">
    <div class="swiper banner-slider">
        <div class="swiper-wrapper">
            @foreach ($upcoming_epooja as $pooja)
            <div class="swiper-slide">
                <a href="{{ route('one-day-puja.details', $pooja->slug) }}">
                    <figure class="image">
                        <img src="{{ $pooja->thumbnail_url ?? $pooja->full_image_url }}"
                            onerror="this.onerror=null; this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';"
                            alt="{{ session('pooja_language') == 'English' ? $pooja->name : $pooja->name_hindi }}">
                    </figure>
                </a>
                <figcaption class="slide-caption">
                    <h3 class="slide-title line-camp-1 overlay-title">
                        {{ session('pooja_language') == 'English' ? $pooja->name : $pooja->name_hindi }}
                    </h3>

                    <div class="login-box">
                        <a href="{{ route('one-day-puja.details', $pooja->slug) }}" class="log">
                            <i class="fas fa-sign-in me-1"></i>
                            BOOK NOW
                        </a>
                    </div>
                </figcaption>

            </div>
            @endforeach
        </div>

        {{-- Optional navigation controls --}}
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

{{-- this is new pooja slider --}}

{{-- <section class="featured-products">
    <h3 class="text-center mb-4"> @if(session()->get('pooja_language')=='English') <h3 class="text-center mb-4">
            All Services
        </h3>
        @else<h3 class="text-center mb-4">
            सभी सेवाएँ</h3> @endif</h3>
    <div class="auto-container">
        <div class="row clearfix">

            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="shop-sidebar">
                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h5> @if(session()->get('pooja_language')=='English') <h5>Categories</h5> @else <h5>
                                    श्रेणियाँ</h5> @endif</h5>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                @foreach (App\Models\Category::where('status', 1)->get() as $category)
                                <li>
                                    <a href="{{ route('listing') }}?category={{ $category->slug }}">
                                        @if (session('pooja_language') == 'English')
                                        {{ $category->name }}
                                        @else
                                        {{ $category->name_hindi }}
                                        @endif
                                    </a>
                                </li>


                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                <div class="mixitup-gallery mt-5 mt-lg-0">
                    <div class="filter-list">
                        <div class="row">
                            @if ($allProducts->isEmpty())
                            <div class="not-found">
                                <img src="{{ asset('frontend/assets/images/404.png') }}">
                                <h1>OPPS! Data is Not Found</h1>
                                <a href="/" class="theme-btn btn-style-one"><span class="btn-title"><i
                                            class="far fa-arrow-alt-circle-left"></i>&nbsp;Back Homepage</span></a>
                            </div>
                        </div>
                        @else
                        @foreach ($allProducts as $product)
                        <div class="col-lg-3 col-6">
                            <div class="product-block all mix pantry fruit d-block">
                                <div class="inner-box">
                                    <div class="image">
                                        <a href="{{ route('details', $product->slug) }}"><img
                                                src="{{ $product->full_image_url }}"
                                                onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';"></a>
                                    </div>
                                    <div class="content">
                                        <h4>
                                            <a href="{{ route('details', $product->slug) }}">
                                                @if(session()->get('pooja_language')=='English') {{ $product->name }}
                                                @else {{ $product->name_hindi }} @endif</a>
                                        </h4>
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
</section> --}}

<!-- Include Bootstrap and FontAwesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
@if (session()->get('pooja_language') == 'English')
<section class="container py-5">
    <h2 class="text-center mb-4">Our Services</h2>
    <div class="row">

        <!-- Puja Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-praying-hands fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">
                        <a href="/puja" class="stretched-link text-decoration-none text-dark">Puja</a>
                    </h5>
                    <p class="card-text">Experience traditional rituals performed by expert priests with devotion and
                        sanctity.</p>
                </div>
            </div>
        </div>

        <!-- E-Puja Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-laptop-house fa-3x mb-3 text-success"></i>
                    <h5 class="card-title">
                        <a href="/e-puja" class="stretched-link text-decoration-none text-dark">E-Puja</a>
                    </h5>
                    <p class="card-text">Join spiritual ceremonies online and participate from the comfort of your home.
                    </p>
                </div>
            </div>
        </div>

        <!-- Teerth Puja Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-place-of-worship fa-3x mb-3 text-danger"></i>
                    <h5 class="card-title">
                        <a href="/teerth-puja-city" class="stretched-link text-decoration-none text-dark">Teerth
                            Puja</a>
                    </h5>
                    <p class="card-text">Perform sacred rituals at holy destinations to seek divine blessings and peace.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>
@else
<section class="container py-5">
    <h2 class="text-center mb-4">हमारी सेवाएं</h2>
    <div class="row">

        <!-- Puja Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-praying-hands fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">
                        <a href="/puja" class="stretched-link text-decoration-none text-dark">पूजा</a>
                    </h5>
                    <p class="card-text">पारंपरिक अनुष्ठानों का अनुभव करें, जिन्हें हमारे विशेषज्ञ पुजारियों द्वारा
                        श्रद्धा और पवित्रता से किया जाता है।</p>
                </div>
            </div>
        </div>

        <!-- E-Puja Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-laptop-house fa-3x mb-3 text-success"></i>
                    <h5 class="card-title">
                        <a href="/e-puja" class="stretched-link text-decoration-none text-dark">ई-पूजा</a>
                    </h5>
                    <p class="card-text">ऑनलाइन आध्यात्मिक अनुष्ठानों से जुड़ें और अपने घर बैठे ही भाग लें।</p>
                </div>
            </div>
        </div>

        <!-- Teerth Puja Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-place-of-worship fa-3x mb-3 text-danger"></i>
                    <h5 class="card-title">
                        <a href="/teerth-puja-city" class="stretched-link text-decoration-none text-dark">तीर्थ पूजा</a>
                    </h5>
                    <p class="card-text">पवित्र स्थलों पर पूजा करके ईश्वरीय आशीर्वाद और शांति प्राप्त करें।</p>
                </div>
            </div>
        </div>

    </div>
</section>
@endif

<div class="checkout-form-section">
    <div class="auto-container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <form action="{{ route('listing') }}" method="GET" enctype="multipart/form-data">
                    @if (session()->get('pooja_language') == 'English')
                    <div class="checkout-form">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gx-7">
                            <div class="select-city select-flex mb-3 me-lg-2 me-0 flex-grow-1">
                                <select id="city" name="city" class="select-input-form js-example-basic-single w-100"
                                    data-live-search="true" onchange="set_city()">
                                    <option value="">Select City</option>
                                    @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                    <option value="{{ $city->city }}" @if (session()->get('city') == $city->city)
                                        selected @endif>
                                        {{ $city->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="select-language select-flex mb-3 me-lg-2 me-0 flex-grow-1">
                                <select id="language" name="language"
                                    class="select-input-form js-example-basic-single w-100" onchange="set_language()">
                                    <option value="">Select Language</option>
                                    @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                    <option value="{{ $language->language }}" @if (session()->get('language') ==
                                        $language->language) selected @endif>
                                        {{ $language->language }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="view-btn">
                                <button class="theme-btn btn-style-one" type="submit">
                                    <span class="btn-title">View services </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                <div class="checkout-form">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gx-7">
                        <div class="select-city select-flex mb-3 me-lg-2 me-0 flex-grow-1">
                            <select id="city" name="city" class="select-input-form js-example-basic-single w-100"
                                data-live-search="true" onchange="set_city()">
                                <option value="">शहर चुनें</option>
                                @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                <option value="{{ $city->city }}" @if (session()->get('city') == $city->city) selected
                                    @endif>
                                    {{ $city->city_name_hindi }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="select-language select-flex mb-3 me-lg-2 me-0 flex-grow-1">
                            <select id="language" name="language"
                                class="select-input-form js-example-basic-single w-100" onchange="set_language()">
                                <option value="">भाषा चुनें</option>
                                @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                <option value="{{ $language->language }}" @if (session()->get('language') ==
                                    $language->language) selected @endif>
                                    {{ $language->language }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="view-btn">
                            <button class="theme-btn btn-style-one" type="submit">
                                <span class="btn-title">सेवाएं देखें</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<section class="service-section-three pujariji-background">
    <div class="auto-container">


        @if (session()->get('pooja_language') == 'English')
        <div class="sec-title wow fadeInUp">
            <h1>
                Upcoming Pujas
                <span>Popular Pujas</span>
            </h1>
        </div>
        @else
        <div class="sec-title wow fadeInUp">
            <h1>
                आगामी पूजाएं
                <span>लोकप्रिय पूजाएं</span>
            </h1>
        </div>
        @endif
        {{-- Location Filter Dropdown --}}
        <div class="carousel-outer">
            <div class="swiper service-three-slider">
                <div class="swiper-wrapper">
                    @foreach ($upcoming_pooja as $upcoming)
                    <div class="swiper-slide">
                        <div class="pujas">
                            <a href="{{ route('details', $upcoming->slug) }}">
                                <img src="{{ $upcoming->full_image_url }}"
                                    onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                            </a>
                            <h4>
                                <a href="{{ route('details', $upcoming->slug) }}" class="line-camp-1">
                                    @if(session()->get('pooja_language') == 'English')
                                    {{ $upcoming->name }}
                                    @else
                                    {{ $upcoming->name_hindi }}
                                    @endif
                                </a>
                            </h4>
                            <button class="theme-primary-btn my-4">
                                <a class="" href="{{ route('details', $upcoming->slug) }}">
                                    <span class="btn-title">Book Now</span>
                                </a>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>

    {{-- Filter Script --}}

</section>


<section class="service-section-two pujariji-background-2">
    @if (session()->get('pooja_language') == 'English')
    <div class="auto-container">
        <div class="sec-title wow fadeInUp animated animated">
            <h1 class="text-white">
                Meet the experienced Pujari's
                <span class="text-white">
                    Our Pujari
                </span>
            </h1>
        </div>
        <div class="carousel-outer">
            <div class="swiper our-pujari-slider">
                <div class="swiper-wrapper">
                    @foreach ($our_pujari as $pujari)
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body py-4">
                                <a href="#">
                                    <img src="{{ uploaded_asset($pujari->image) }}"
                                        onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                                </a>
                                <h4>
                                    <a href="#" class="line-camp-1">{{ $pujari->name }}</a>
                                </h4>
                                <p>{{ $pujari->city }}, <span>Exp : {{ $pujari->exp }} years</span></p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="auto-container">
        <div class="sec-title wow fadeInUp animated animated">
            <h1 class="text-white">
                मिलिए अनुभवी पुजारियों से
                <span class="text-white">
                    हमारे पुजारी
                </span>
            </h1>
        </div>
        <div class="carousel-outer">
            <div class="swiper our-pujari-slider">
                <div class="swiper-wrapper">
                    @foreach ($our_pujari as $pujari)
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body py-4">
                                <a href="#">
                                    <img src="{{ uploaded_asset($pujari->image) }}"
                                        onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                                </a>
                                <h4>
                                    <a href="#" class="line-camp-1">{{ $pujari->name_hindi }}</a>
                                </h4>
                                <p>{{ $pujari->city_hindi }}, <span>अनुभव: {{ $pujari->exp }} वर्ष</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

<section class="service-section-three pujariji-background">
    <div class="auto-container">
        @if (session()->get('pooja_language') == 'English')
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                Upcoming E-Pujas
                <span>

                    Popular E-Pujas
                </span>
            </h1>
        </div>
        <div class="carousel-outer">
            <div class="swiper service-three-slider">
                <div class="swiper-wrapper">
                    @foreach ($upcoming_epooja as $upcoming_e)
                    <div class="swiper-slide">
                        <div class="pujas">
                            <a href="{{ route('one-day-puja.details', $upcoming_e->slug) }}">
                                <img src="{{ $upcoming_e->full_image_url }}"
                                    onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';"
                                    style="width: 100%; height: 250px; object-fit: cover;" alt="Event Image">
                            </a>

                            <h4>
                                <a href="{{ route('details', $upcoming_e->slug) }}" class="line-camp-1">{{
                                    $upcoming_e->name }}</a>
                            </h4>
                            <button class="theme-primary-btn my-4">
                                <a href="{{ route('details', $upcoming_e->slug) }}">
                                    <span class="btn-title">BOOK NOW</span>
                                </a>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        @else
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                आगामी ई-पूजाएं
                <span>
                    लोकप्रिय ई-पूजाएं
                </span>
            </h1>
        </div>
        <div class="carousel-outer">
            <div class="swiper service-three-slider">
                <div class="swiper-wrapper">
                    @foreach ($upcoming_epooja as $upcoming_e)
                    <div class="swiper-slide">
                        <div class="pujas">
                            <a href="{{ route('one-day-puja.details', $upcoming_e->slug) }}">
                                <img src="{{ $upcoming_e->full_image_url }}"
                                    onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';">
                            </a>
                            <h4>
                                <a href="{{ route('details', $upcoming_e->slug) }}" class="line-camp-1">{{
                                    $upcoming_e->name_hindi }}</a>
                            </h4>
                            <button class="theme-btn btn-style-one"><a href="{{ route('details', $upcoming_e->slug) }}">
                                    <span class="btn-title">Book Now</span>
                                </a>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        @endif

    </div>
</section>
<section class="about-section service-section-three">
    <div class="auto-container">
        <div class="row align-items-center">
            <div class="content-column col-xl-6 col-lg-6 order-lg-2 wow fadeInRight" data-wow-delay="600ms">
                <div class="inner-column">
                    @if (session()->get('pooja_language') == 'English')
                    <div class="sec-title wow fadeInUp animated animated">
                        <h1>
                            Book {{ env('APP_NAME') }} For Puja.
                            <span>
                                {{ env('APP_NAME') }}
                            </span>
                        </h1>
                        <div class="text">
                            <p>{{ env('APP_NAME') }} is the most trusted platform for availing Vedic and Hindu
                                Puja
                                Services like
                                performing Vedic Rituals, Religious Ceremonies, Vastu Yagya and many more. We
                                provide
                                the best experienced and well-known purohits and pandits at your place to do puja.
                                We
                                are leading Pandit Booking website. Now, you can perform your pooja with our
                                Professional Purohits & Pandits.</p>
                            <p>Our perform rituals like Havan, Yagya, Shanti Vidhi, Shubh Vivah – Wedding
                                Ceremony,
                                Satyanarayan Katha, Griha Pravesh, Namkaran Sanskar, Nava Graha Shanti,
                                Engagement,
                                Festival Puja, Janeu, Ganesh Puja, Ram Katha, Mundan Sanskar, Shrimant Puja,
                                Namkaran,
                                Bhagwat Katha, Vastu Shanti, etc.</p>
                            <p>We provide highly qualified and experienced Panditji for all communities like
                                Gujarati,
                                Rajasthani, Marathi, Sindhi, Bihari, Bengali, and Panjabi.</p>
                        </div>
                    </div>
                    <div class="btn-box">
                        <a href="{{ route('about') }}" class="theme-btn btn-style-one"><span class="btn-title">Discover
                                More</span></a>
                        <div class="contact-info">
                            <div class="icon-box"><i class="flaticon-customer-service"></i></div>
                            <span>Booking Now</span>
                            @if (!empty(appSetupValue('contact_number')))
                            <h4 class="title">+91-{{ appSetupValue('contact_number') }}</h4>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="sec-title wow fadeInUp animated animated">
                        <h1>
                            पूजा के लिए पुजारी जी बुक करें।
                            <span>
                                पुजारी जी
                            </span>
                        </h1>
                        <div class="text">
                            <p>पुजारी जी वैदिक और हिंदू पूजा सेवाओं जैसे वैदिक अनुष्ठान, धार्मिक
                                समारोह, वास्तु यज्ञ और कई अन्य के लिए सबसे विश्वसनीय प्लेटफॉर्म है।
                                हम आपको पूजा के लिए आपके स्थान पर सबसे अनुभवी और प्रसिद्ध पुरोहित और पंडित प्रदान
                                करते हैं।
                                हम अग्रणी पंडित बुकिंग वेबसाइट हैं। अब, आप हमारे पेशेवर पुरोहितों और पंडितों के
                                साथ अपनी पूजा कर सकते हैं।</p>
                            <p>हम हवन, यज्ञ, शांति विधि, शुभ विवाह – विवाह समारोह, सत्यनारायण कथा, गृह प्रवेश,
                                नामकरण संस्कार, नवग्रह शांति, सगाई,
                                त्योहार पूजा, जनेऊ, गणेश पूजा, राम कथा, मुंडन संस्कार, श्रीमंत पूजा, नामकरण, भागवत
                                कथा, वास्तु शांति आदि अनुष्ठान करते हैं।</p>
                            <p>हम सभी समुदायों जैसे गुजराती, राजस्थानी, मराठी, सिंधी, बिहारी, बंगाली और पंजाबी के
                                लिए उच्च योग्य और अनुभवी पंडितजी प्रदान करते हैं।</p>
                        </div>
                    </div>
                    <div class="btn-box">
                        <a href="{{ route('about') }}" class="theme-btn btn-style-one">
                            <span class="btn-title">और जानें</span>
                        </a>
                        <div class="contact-info">
                            <div class="icon-box"><i class="flaticon-customer-service"></i></div>
                            <span>अभी बुक करें</span>
                            @if (!empty(appSetupValue('contact_number')))
                            <h4 class="title">+91-{{ appSetupValue('contact_number') }}</h4>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="image-column col-xl-6 col-lg-6">
                <div class="inner-column wow fadeInLeft">
                    <figure class="image-2 overlay-anim wow fadeInLeft">
                        <img src="{{ asset('frontend/assets/images/welcome-to-pujari-ji.png') }}">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="service-section-two pujariji-background-2">
    <div class="auto-container">
        @if (session()->get('pooja_language') == 'English')
        <div class="sec-title wow fadeInUp animated animated">
            <h1 class="text-white">
                {{ env('APP_NAME') }}</span> Our Achievements
                <span class="text-white">
                    Achievements
                </span>
            </h1>
        </div>
        <div class="fact-counter">
            <div class="row">
                <div class="counter-block-one col-lg-3 col-6">
                    <div class="inner-box">
                        <img src="{{ asset('frontend/assets/images/puja-performed.png') }}">
                        <div class="count-box"> <span class="count-text" data-speed="10000"
                                data-stop="10000">0</span><sup>+</sup></div>
                        <div class="counter-text">Puja Performed</div>
                    </div>
                </div>
                <div class="counter-block-one col-lg-3 col-6">
                    <div class="inner-box">
                        <img src="{{ asset('frontend/assets/images/pandit-ji.png') }}">
                        <div class="count-box"><span class="count-text" data-speed="2000"
                                data-stop="2000">0</span><sup>+</sup></div>
                        <div class="counter-text">Pandit ji Listed</div>
                    </div>
                </div>
                <div class="counter-block-one col-lg-3 col-6">
                    <div class="inner-box">
                        <img src="{{ asset('frontend/assets/images/puja.png') }}">
                        <div class="count-box"><span class="count-text" data-speed="300"
                                data-stop="300">0</span><sup>+</sup></div>
                        <div class="counter-text">Type of Puja</div>
                    </div>
                </div>
                <div class="counter-block-one col-lg-3 col-6">
                    <div class="inner-box">
                        <img src="{{ asset('frontend/assets/images/customer.png') }}">
                        <div class="count-box"><span class="count-text" data-speed="10000"
                                data-stop="10000">0</span><sup>+</sup></div>
                        <div class="counter-text">Satisfied Customers</div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                पुजारी जी हमारे उपलब्धियां
                <span>
                    उपलब्धियां
                </span>
            </h1>
        </div>
        <div class="fact-counter">
            <div class="row">
                <div class="counter-block-one col-lg-3 col-6">
                    <div class="inner-box">
                        <img src="{{ asset('frontend/assets/images/puja-performed.png') }}">
                        <div class="count-box">
                            <span class="count-text" data-speed="10000" data-stop="10000">0</span><sup>+</sup>
                        </div>
                        <div class="counter-text">संपन्न पूजा</div>
                    </div>
                </div>
                <div class="counter-block-one col-lg-3 col-6">
                    <div class="inner-box">
                        <img src="{{ asset('frontend/assets/images/pandit-ji.png') }}">
                        <div class="count-box">
                            <span class="count-text" data-speed="2000" data-stop="2000">0</span><sup>+</sup>
                        </div>
                        <div class="counter-text">पंजीकृत पंडित जी</div>
                    </div>
                </div>
                <div class="counter-block-one col-lg-3 col-6">
                    <div class="inner-box">
                        <img src="{{ asset('frontend/assets/images/puja.png') }}">
                        <div class="count-box">
                            <span class="count-text" data-speed="300" data-stop="300">0</span><sup>+</sup>
                        </div>
                        <div class="counter-text">पूजा के प्रकार</div>
                    </div>
                </div>
                <div class="counter-block-one col-lg-3 col-6">
                    <div class="inner-box">
                        <img src="{{ asset('frontend/assets/images/customer.png') }}">
                        <div class="count-box">
                            <span class="count-text" data-speed="10000" data-stop="10000">0</span><sup>+</sup>
                        </div>
                        <div class="counter-text">संतुष्ट ग्राहक</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<section class="service-section-three pujariji-background">
    <div class="auto-container">
        @if (session()->get('pooja_language') == 'English')
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                How {{ env('APP_NAME') }} Works
                <span>
                    How it Works
                </span>
            </h1>
        </div>
        <div class="col-md-12">
            <p class="text-center">{{ env('APP_NAME') }} Provides Sacred, Hassle-Free Puja Services performed by
                qualified Pandits and Purohits. Book a Pandit Ji online with all Puja samagri sent to your
                doorsteps.
                Truly Hassle-Free Puja services performed by verified Pandits.</p>
        </div>
        <div class="row mt-4">
            <div class="service-block col-lg-3 col-sm-6">
                <div class="inner-box wow fadeIn" data-wow-delay="100ms">
                    <div class="icon-box wow fadeInUp">
                        <img src="{{ asset('frontend/assets/images/works-1.svg') }}">
                    </div>
                    <div class="content-box">
                        <h4 class="title">Select a Puja</h4>
                        <div class="text">Select a Puja along with the package of your choice. </div>
                    </div>
                </div>
            </div>
            <div class="service-block col-lg-3 col-sm-6">
                <div class="inner-box wow fadeIn" data-wow-delay="200ms">
                    <div class="icon-box wow fadeInUp">
                        <img src="{{ asset('frontend/assets/images/works-2.svg') }}">
                    </div>
                    <div class="content-box">
                        <h4 class="title">Book a Pandit</h4>
                        <div class="text">Select your language preference for Pandit Ji.</div>
                    </div>
                </div>
            </div>
            <div class="service-block col-lg-3 col-sm-6">
                <div class="inner-box wow fadeIn" data-wow-delay="300ms">
                    <div class="icon-box wow fadeInUp">
                        <img src="{{ asset('frontend/assets/images/works-3.svg') }}">
                    </div>
                    <div class="content-box">
                        <h4 class="title">Get your confirmation</h4>
                        <div class="text">Book with advance payment and get a confirmed booking. </div>
                    </div>
                </div>
            </div>
            <div class="service-block col-lg-3 col-sm-6">
                <div class="inner-box wow fadeIn" data-wow-delay="300ms">
                    <div class="icon-box wow fadeInUp">
                        <img src="{{ asset('frontend/assets/images/works-4.svg') }}">
                    </div>
                    <div class="content-box">
                        <h4 class="title">Get frequent updates</h4>
                        <div class="text">All details are shared on email, sms and Whatsapp.</div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                पुजारी जी कैसे काम करता है
                <span>
                    यह कैसे काम करता है
                </span>
            </h1>
        </div>
        <div class="col-md-12">
            <p class="text-center">पुजारी जी पवित्र, परेशानी-मुक्त पूजा सेवाएं प्रदान करता है, जो
                योग्य पंडितों और पुरोहितों द्वारा संपन्न की जाती हैं।
                पंडित जी को ऑनलाइन बुक करें और सभी पूजा सामग्री आपके दरवाजे तक पहुंचाई जाएगी।
                प्रमाणित पंडितों द्वारा पूरी तरह से परेशानी-मुक्त पूजा सेवाएं।</p>
        </div>
        <div class="row mt-4">
            <div class="service-block col-lg-3 col-sm-6">
                <div class="inner-box wow fadeIn" data-wow-delay="100ms">
                    <div class="icon-box wow fadeInUp">
                        <img src="{{ asset('frontend/assets/images/works-1.svg') }}">
                    </div>
                    <div class="content-box">
                        <h4 class="title">एक पूजा चुनें</h4>
                        <div class="text">अपनी पसंद का पैकेज के साथ एक पूजा चुनें।</div>
                    </div>
                </div>
            </div>
            <div class="service-block col-lg-3 col-sm-6">
                <div class="inner-box wow fadeIn" data-wow-delay="200ms">
                    <div class="icon-box wow fadeInUp">
                        <img src="{{ asset('frontend/assets/images/works-2.svg') }}">
                    </div>
                    <div class="content-box">
                        <h4 class="title">एक पंडित बुक करें</h4>
                        <div class="text">पंडित जी के लिए अपनी भाषा की प्राथमिकता चुनें।</div>
                    </div>
                </div>
            </div>
            <div class="service-block col-lg-3 col-sm-6">
                <div class="inner-box wow fadeIn" data-wow-delay="300ms">
                    <div class="icon-box wow fadeInUp">
                        <img src="{{ asset('frontend/assets/images/works-3.svg') }}">
                    </div>
                    <div class="content-box">
                        <h4 class="title">अपना पुष्टि प्राप्त करें</h4>
                        <div class="text">एडवांस भुगतान के साथ बुक करें और एक पुष्ट बुकिंग प्राप्त करें।</div>
                    </div>
                </div>
            </div>
            <div class="service-block col-lg-3 col-sm-6">
                <div class="inner-box wow fadeIn" data-wow-delay="300ms">
                    <div class="icon-box wow fadeInUp">
                        <img src="{{ asset('frontend/assets/images/works-4.svg') }}">
                    </div>
                    <div class="content-box">
                        <h4 class="title">बार-बार अपडेट प्राप्त करें</h4>
                        <div class="text">सभी विवरण ईमेल, एसएमएस और व्हाट्सएप पर साझा किए जाते हैं।</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
</section>
<section class="testimonial-section-two service-section-two pujariji-background-2">
    <div class="auto-container">
        @if (session()->get('pooja_language') == 'English')
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                What Client's Say?
                <span>
                    OUR CUSTOMER FEEDBACK
                </span>
            </h1>
        </div>
        @else
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                हमारे ग्राहक क्या कहते हैं?
                <span>
                    हमारे ग्राहक की प्रतिक्रिया
                </span>
            </h1>
        </div>
        @endif
        <div class="row">
            <div class="testimonials overflow-hidden col-lg-8 m-auto offset-lg-1">
                <div class="swiper-container testimonial-slider-content">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $test)
                        <div class="testimonial-block-two swiper-slide">
                            <div class="inner-box">
                                <div class="quote-icon"><i class="icon fa fa-quote-left"></i></div>
                                <div class="text">{!! $test->description !!}</div>
                                <div class="info-box">
                                    <h5 class="name">{{ $test->name }}</h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-container testimonial-thumbs mx-auto">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $test)
                        <div class="swiper-slide"><img src="{{ $test->full_image_url }}"
                                onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/resource/testi2-thumb1.png') }}'" />
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
<section class="seprate-banner">
    @php $banner=App\Models\Banner::where('status',1)->first(); @endphp
    @if (!empty($banner->full_image_url))
    <img src="{{ $banner->full_image_url }}" class="w-100">
    {{-- @else
    <img src="{{ asset('frontend/pujari/new-banner-2.jpg') }}"> --}}
    @endif
</section>
{{-- This is moved to new Blog Page --}}
{{-- <section class="news-section service-section-three pujariji-background">
    <div class="auto-container">
        @if (session()->get('pooja_language') == 'English')
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                {{ env('APP_NAME') }} Blogs
                <span>
                    Latest Update
                </span>
            </h1>
        </div>
        <div class="row">
            @foreach ($blogs as $blog)
            <div class="news-block col-lg-4 col-md-6 wow fadeInUp">
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
                        <a href="{{ route('blogs', $blog->slug) }}" class="read-more">Read More
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="sec-title wow fadeInUp animated animated">
            <h1>
                पुजारी जी ब्लॉग
                <span>
                    ताजा अपडेट
                </span>
            </h1>
        </div>
        <div class="row">
            @foreach ($blogs as $blog)
            <div class="news-block col-lg-4 col-md-6 wow fadeInUp">
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
                        <a href="{{ route('blogs', $blog->slug) }}" class="read-more">और पढ़ें
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section> --}}
@endsection
@push('scripts')
<script>
    const audio = document.getElementById('shankhSound');
          let isPlaying = false;

          document.addEventListener('click', () => {
              if (!isPlaying) {
                  //   document.getElementById('shankhSound').play();
                  //   document.getElementById('ghantiSound').play();
                  //   document.getElementById('damaruSound').play();
                  //   isPlaying = true;
              }
          });
</script>


<script>
    function getPincode() {
              var city_id = $('#city').val();
              $.ajax({
                  url: "{{ route('get-pincodes') }}", // Laravel route
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
                              `<option value="${city.pincode}" selected>${city.pincode}</option>`
                          );
                      });
                  },
                  error: function(xhr) {
                      console.log("Error:", xhr);
                  }
              });
          }

          //   window.addEventListener('load', function() {
          //       // Hide the loader
          //       document.getElementById('loader').style.display = 'none';
          //       // Show the content
          //       document.getElementById('content').style.display = 'block';
          //   });
</script>
@endpush