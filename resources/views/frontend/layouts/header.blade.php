{{-- <header @if (Route::is('index')) id="header" @else id="header2" @endif class="fixed-top d-flex align-items-center">
</header> --}}
@php
$user_id = '';
$check_user = Auth::check();

if ($check_user) {
$user_id = Auth::user()->id;
} else {
$check_session = Session::get('guest_id');
if ($check_session) {
$user_id = $check_session;
}
}
$cart_total_item = App\Models\Cart::where('user_id', $user_id)->whereHas('product', function ($query) {
$query->where('product_type', '!=', 'one_day');
})->count();
@endphp

<header class="main-header @if (Route::is('index')) header-style-one @else header-style-one @endif">
    {{-- <section class="as_header_wrapper">
        <div class="as_info_detail">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6 d-lg-block d-none">
                        <ul>
                            @if (appSetupValue('contact_number'))
                            <li>
                                <a href="javascript:;">
                                    <div class="as_infobox">
                                        <span class="as_infoicon">
                                            <i class="far fa-phone-volume"></i>
                                        </span>
                                        +91 {{ appSetupValue('contact_number') }}
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if (appSetupValue('email'))
                            <li>
                                <a href="javascript:;">
                                    <div class="as_infobox m-auto">
                                        <span class="as_infoicon"><i class="far fa-envelope-open"></i>
                                        </span>
                                        {{ appSetupValue('email') }}
                                    </div>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-lg-6 text-end">
                        <div class="main-right">
                            <ul class="navigation">
                                <li class="dropdown">
                                    <div class="select-language">
                                        <select name="pooja_language" id="pooja_language"
                                            onchange="set_pooja_language()">
                                            <option value="hindi" @if (session()->get('pooja_language') == 'hindi')
                                                selected @endif @if (empty(session()->get('pooja_language'))) selected
                                                @endif>
                                                Hindi
                                            </option>
                                            <option value="English" @if (session()->get('pooja_language') == 'English')
                                                selected @endif>
                                                English
                                            </option>

                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <div class="container-fluid">
        <div class="main-box d-flex justify-content-between align-items-center">
            <div class="logo-box">
                <div class="logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}"
                            onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/logo-white.png') }}'">
                    </a>
                </div>
            </div>
            <div class="nav-outer">
                <nav class="nav main-menu">
                    @if (session()->get('pooja_language') == 'English')
                    <ul class="navigation">
                        <li class="{{ request()->routeIs('index') ? 'active' : '' }}">
                            <a href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('puja') ? 'active' : '' }}">
                            <a href="{{ route('puja') }}">Puja</a>
                        </li>
                        <li class="{{ request()->routeIs('one-day-puja') ? 'active' : '' }}">
                            <a href="{{ route('one-day-puja') }}">E-Puja</a>
                        </li>
                        <li class="{{ request()->routeIs('teerth-puja-city') ? 'active' : '' }}">
                            <a href="{{ route('teerth-puja-city') }}">Teerth Puja</a>
                        </li>
                        <li class="{{ request()->routeIs('blog') ? 'active' : '' }}">
                            <a href="{{ route('blog') }}">Blog</a>
                        </li>
                        @if (appSetupValue('more_show'))
                        <li class="dropdown">
                            <a href="#">More</a>
                            <ul>
                                <li>
                                    <a href="{{ route('panchang') }}">Panchang</a>
                                </li>
                                <li>
                                    <a href="{{ route('yearly-horoscope') }}">Yearly Horoscopes</a>
                                </li>
                                <li>
                                    <a href="{{ route('weekly-horoscope') }}">Weekly Horoscopes</a>
                                </li>
                                <li>
                                    <a href="{{ route('daily-horoscope') }}">Today Horoscopes</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Auth::check())
                        <li class="d-lg-none d-md-none d-block {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">Profile</a>
                        </li>
                        @else
                        <li class="d-lg-none d-md-none d-block {{ request()->routeIs('login') ? 'active' : '' }}">
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        @endif
                    </ul>
                    @else
                    <ul class="navigation">
                        <li class="{{ request()->routeIs('index') ? 'active' : '' }}">
                            <a href="{{ route('index') }}">होम</a>
                        </li>
                        <li class="{{ request()->routeIs('puja') ? 'active' : '' }}">
                            <a href="{{ route('puja') }}">पूजा</a>
                        </li>
                        <li class="{{ request()->routeIs('one-day-puja') ? 'active' : '' }}">
                            <a href="{{ route('one-day-puja') }}">ई-पूजा</a>
                        </li>
                        <li class="{{ request()->routeIs('teerth-puja-city') ? 'active' : '' }}">
                            <a href="{{ route('teerth-puja-city') }}">तीर्थ पूजा</a>
                        </li>
                        @if (appSetupValue('more_show'))
                        <li class="dropdown">
                            <a href="#">अधिक</a>
                            <ul>
                                <li>
                                    <a href="{{ route('panchang') }}">पंचांग</a>
                                </li>
                                <li>
                                    <a href="{{ route('yearly-horoscope') }}">वार्षिक राशिफल</a>
                                </li>
                                <li>
                                    <a href="{{ route('weekly-horoscope') }}">साप्ताहिक राशिफल</a>
                                </li>
                                <li>
                                    <a href="{{ route('daily-horoscope') }}">आज का राशिफल</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Auth::check())
                        <li class="d-lg-none d-md-none d-block {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">प्रोफाइल</a>
                        </li>
                        @else
                        <li class="d-lg-none d-md-none d-block {{ request()->routeIs('login') ? 'active' : '' }}">
                            <a href="{{ route('login') }}">लॉगिन</a>
                        </li>
                        @endif
                    </ul>
                    @endif
                </nav>
            </div>
            <div class="language me-3">
                <div class="checkbox">
                    <input type="checkbox" id="cbx" style="display:none" @if (session('pooja_language')=='English' )
                        checked @endif />
                    <label for="cbx" class="toggle"><span></span></label>
                </div>


            </div>
            <div class="cart me-3">
                <a href="{{ route('cart') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <p class="cart-wrap"><span id="cart_count">{{ $cart_total_item }}</span></p>
                </a>
            </div>
            <div class="outer-box">
                @if (session()->get('pooja_language') == 'English')

                @if (Auth::check())
                <div class="login-box">
                    <a href="{{ route('dashboard') }}" class="log">
                        <i class="fas fa-user me-1"></i>
                        Profile
                    </a>
                </div>
                <div class="mobile-nav-toggler">
                    <span class="icon lnr-icon-bars">
                    </span>
                </div>
                @else
                <div class="login-box">
                    <a href="{{ route('login') }}" class="log">
                        <i class="fas fa-sign-in me-1"></i>
                        Login
                    </a>
                </div>
                <div class="mobile-nav-toggler">
                    <span class="icon lnr-icon-bars"></span>
                </div>
                @endif
                @else
                @if (Auth::check())
                <div class="login-box">
                    <a href="{{ route('dashboard') }}" class="log">
                        <i class="fas fa-user me-1"></i>
                        प्रोफ़ाइल
                    </a>
                </div>
                <div class="mobile-nav-toggler">
                    <span class="icon lnr-icon-bars">
                    </span>
                </div>
                @else
                <div class="login-box">
                    <a href="{{ route('login') }}" class="log">
                        <i class="fas fa-sign-in me-1"></i>
                        लॉगिन
                    </a>
                </div>
                <div class="mobile-nav-toggler">
                    <span class="icon lnr-icon-bars"></span>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <nav class="menu-box">
            <div class="upper-box">
                <div class="nav-logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}"
                            onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/logo-white.png') }}'">
                    </a>
                </div>
                <div class="close-btn"><i class="icon fa fa-times"></i></div>
            </div>
            <ul class="navigation clearfix">
            </ul>
            <ul class="contact-list-one">
                <li>
                    <div class="contact-info-box">
                        <i class="icon lnr-icon-phone-handset"></i>
                        @if (!empty(appSetupValue('contact_number')))
                        <a href="tel:+91-{{ appSetupValue('contact_number') }}">+91-{{ appSetupValue('contact_number')
                            }}</a>
                        @endif
                    </div>
                </li>
                <li>
                    <div class="contact-info-box">
                        <span class="icon lnr-icon-envelope1"></span>
                        @if (!empty(appSetupValue('email')))
                        <a href="mailto:{{ appSetupValue('email') }}">{{ appSetupValue('email') }}</a>
                        @endif
                    </div>
                </li>
            </ul>
            <ul class="social-links">
                @if (!empty(appSetupValue('facebook')))
                <li>
                    <a href="{{ appSetupValue('facebook') }}"><i class="fab fa-facebook"></i></a>
                </li>
                @endif
                @if (!empty(appSetupValue('twitter')))
                <li>
                    <a href="{{ appSetupValue('twitter') }}"><i class="fab fa-twitter"></i></a>
                </li>
                @endif
                @if (!empty(appSetupValue('instagram')))
                <li>
                    <a href="{{ appSetupValue('instagram') }}"><i class="fab fa-instagram"></i></a>
                </li>
                @endif
                @if (!empty(appSetupValue('youtube')))
                <li>
                    <a href="{{ appSetupValue('youtube') }}"><i class="fab fa-youtube"></i></a>
                </li>
                @endif
                @if (!empty(appSetupValue('linkedin')))
                <li>
                    <a href="{{ appSetupValue('linkedin') }}"><i class="fab fa-linkedin-in"></i></a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
    {{-- <div class="sticky-header">
        <div class="container">
            <div class="inner-container">
                <div class="logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}"
                            onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/logo-white.png') }}'">
                    </a>
                </div>
                <div class="nav-outer">
                    <nav class="main-menu">
                        <div class="navbar-collapse show collapse clearfix">
                            <ul class="navigation clearfix">
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="cart mr-10">
                    <a href="{{ route('cart') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <p class="cart-wrap"><span id="cart_count">{{ $cart_total_item }}</span></p>
                    </a>
                </div>
                <div class="outer-box ms-4">
                    @if (Auth::check())
                    <a href="{{ route('dashboard') }}" class="login-custom p-3">
                        <i class="fas fa-user mt-2"></i>
                    </a>
                    <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    @else
                    <a href="{{ route('login') }}" class="login-custom p-3">
                        <i class="fas fa-sign-in me-1" aria-hidden="true"></i></a>

                    <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}
    </div>
</header>

@if (request()->route()->getName() == 'puja' || request()->route()->getName() == 'listing')
{{-- <section class="page-title">
    <div class="auto-container">
        <div class="row">
            <!-- Left Section -->
            <div class="col-12 col-lg-8 mb-3">
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
                            <div class="view-button">
                                <button class="theme-btn btn-style-one pack-btn" type="submit">
                                    <span class="btn-title">View All Services</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="checkout-form">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="select-city mb-3 me-2 flex-grow-1">
                                <select id="city" name="city" class="select-input-form js-example-basic-single w-100"
                                    data-live-search="true" onchange="set_city()">
                                    <option value="">शहर चुनें</option>
                                    @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                    <option value="{{ $city->city }}" @if (session()->get('city') == $city->city)
                                        selected @endif>
                                        {{ $city->city }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="select-language mb-3 me-lg-2 me-0 flex-grow-1">
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
                            <div class="view-button">
                                <button class="theme-btn btn-style-one pack-btn" type="submit">
                                    <span class="btn-title">सभी सेवाएं देखें</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            <!-- Right Section -->
            @if (session()->get('pooja_language') == 'English')
            <div class="col-lg-4 col-12">
                <div class="sidebar-search">
                    <form action="{{ route('listing') }}" method="GET" class="search-form">
                        <div class="form-group d-flex">
                            <input type="search" name="search" placeholder="Search..." value="{{ request('search') }}"
                                required="">
                            <button><i class="lnr lnr-icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="col-lg-4 col-12">
                <div class="sidebar-search">
                    <form action="{{ route('listing') }}" method="GET" class="search-form">
                        <div class="form-group d-flex">
                            <input type="search" name="search" placeholder="खोजें..." value="{{ request('search') }}"
                                required="">
                            <button><i class="lnr lnr-icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</section> --}}
@endif