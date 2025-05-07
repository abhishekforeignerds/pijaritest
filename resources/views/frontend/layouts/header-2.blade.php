{{-- <header @if (Route::is('index')) id="header" @else id="header2" @endif class="fixed-top d-flex align-items-center">
</header> --}}

<style>
    .header-style-one .outer-box .header-btn {
        font-size: 13px;
        letter-spacing: 0.5px;
        line-height: 45px;
        width: 130px;
        margin-top: 0;
        top: 0;
        height: 45px;
    }

    @media(max-width:575.98px) {

        .header-serch-section .btn-style-one {
            margin-top: 35px !important;
        }

        .main-header .main-box {
            display: grid;
        }

        .sidebar-search {
            display: inline-block;
            margin-top: 5px;
            float: right;
        }

        .own-headerrightsection {
            margin-top: 0;
        }

        .header-style-one .outer-box .header-btn {
            font-size: 13px;
            line-height: 40px;
            width: 130px;
            letter-spacing: 0.5px;
            height: 40px;
        }

    }

    @media only screen and (max-width: 480px) {
        .header-style-one .outer-box .header-btn {
            display: block;
            margin: 7px 0 0;
        }

        .checkout-form .form-control,
        .input-text {
            padding: 10px;
            font-size: 13px;
            width: 58% !important;
            float: right;
            margin: 6px 0 0 0;
        }

        .header-serch-section {
            width: 100%;
            display: block;
            margin: 0 auto;
        }

        .header-citysearch,
        .header-priestsearch {
            float: none;
            width: 100%;
        }

        .templetesearvice {
            float: right;
        }

        .main-header .outer-box {
            height: auto;
        }

        .header-serch-section .btn-style-one {
            display: none;
        }

    }
</style>

@php
$user_id = 0;
$check_user = Auth::check();

if ($check_user) {
$user_id = Auth::user()->id;
} else {
$check_session = Session::get('guest_id');
if ($check_session) {
$user_id = $check_session;
}
}

$cart_total_item = App\Models\Cart::where('user_id', $user_id)->count();
@endphp
<header class="main-header @if (Route::is('index')) header-style-one @else header-style-one @endif">
    <div class="auto-container">
        <div class="nav-outer">
            <nav class="nav main-menu top-menu">
                <ul class="navigation">
                    <li class="{{ request()->routeIs('index') ? 'active' : '' }}">
                        <a href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="{{ request()->routeIs('puja') ? 'active' : '' }}">
                        <a href="{{route('puja')}}">Puja</a>
                    </li>
                    <li class="{{ request()->routeIs('one-day-puja') ? 'active' : '' }}">
                        <a href="{{ route('one-day-puja') }}">One Day Puja</a>
                    </li>
                    {{-- <li class="dropdown"><a href="#">Teerth Puja</a>
                        <ul>
                            @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                            <li><a href="{{route('teerth_puja',$city->city)}}">{{ $city->city }}</a></li>
                            @endforeach
                        </ul>
                    </li> --}}
                    <li class="{{ request()->routeIs('teerth-puja-city') ? 'active' : '' }}">
                        <a href="{{route('teerth-puja-city')}}">Teerth Puja</a>
                    </li>
                    <li class="{{ request()->routeIs('panchang') ? 'active' : '' }}">
                        <a href="{{route('panchang')}}">Panchang</a>
                    </li>
                </ul>

                <div class="outer-box mr-10">
                    @if (Auth::check())
                    <a href="{{ route('login') }}" class="header-btn">Profile</a>
                    <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    @else
                    <a href="{{ route('login') }}" class="header-btn">Login</a>
                    <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    @endif
                </div>
            </nav>
        </div>

        <div class="main-box justify-content-between">
            <div class="logo-box d-lg-block d-md-block d-none">
                <div class="logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('backend/images/app_setup/' . appSetupValue('logo')) }}"
                            onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/logo-white.png') }}'">
                    </a>
                </div>
            </div>
            <div class="headser">
                <div class="checkout-form">
                    <div class="header-serch-section">
                        <form action="{{ route('listing') }}" method="GET" enctype="multipart/form-data">
                            <div class="header-citysearch">
                                <label for="city" class="lb">Choose City</label>
                                <select id="city" name="city" class="form-control selectpicker" id="select-country"
                                    data-live-search="true">
                                    <option value="">Select City</option>
                                    @foreach (App\Models\ServiceCity::where('status', 'active')->get() as $city)
                                    <option value="{{ $city->city }}" @if(session()->get('city')==$city->city) selected
                                        @endif>{{ $city->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="header-priestsearch">
                                <label for="language" class="lb">Choose Language</label>
                                <select id="language" name="language" class="form-control">
                                    <option value="">Select Language</option>
                                    @foreach (App\Models\Language::where('status', 'active')->get() as $language)
                                    <option value="{{ $language->language }}" @if(session()->
                                        get('language')==$language->language) selected @endif>{{ $language->language }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="theme-btn btn-style-one" type="submit"><span class="btn-title">View All
                                    services </span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="own-headerrightsection">
                <div class="sidebar-search">
                    <form action="{{route('listing')}}" method="GET" class="search-form">
                        <div class="form-group">
                            <input type="search" name="search" placeholder="Search..." value="{{request('search')}}"
                                required="">
                            <button><i class="lnr lnr-icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="templetesearvice d-lg-none d-md-none d-block">
                    <div class="outer-box">

                        &nbsp;
                        {{-- <a href="{{route('panchang')}}" class="header-btn ml-5">Panchang</a> --}}
                        @if (Auth::check())
                        <a href="{{ route('dashboard') }}" class="header-btn">Profile</a>
                        {{-- <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div> --}}
                        @else
                        <a href="{{ route('login') }}" class="header-btn">Login</a>
                        {{-- <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div> --}}
                        @endif
                    </div>
                    {{-- <div class="cart">
                        <a href="{{ route('cart') }}">
                            <i class="fas fa-shopping-bag"></i>
                            <p class="cart-wrap"><span id="cart_count">{{ $cart_total_item }}</span></p>
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="mobile-menu bg-white">
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
                            <a href="tel:+91-{{ appSetupValue('contact_number') }}">+91-{{
                                appSetupValue('contact_number') }}</a>
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

        <div class="sticky-header d-none">
            <div class="auto-container">
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
                    {{-- <div class="outer-box">
                        <a href="{{ route('pujari-login') }}" class="header-btn">Partner Login</a>
                    </div> --}}
                    <div class="outer-box">
                        @if (Auth::check())
                        <a href="{{ route('login') }}" class="header-btn">Profile</a>
                        <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                        @else
                        <a href="{{ route('login') }}" class="header-btn">Login</a>
                        <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                        @endif
                    </div>
                    <div class="cart">
                        <a href="{{ route('cart') }}">
                            <i class="fas fa-shopping-bag"></i>
                            <p class="cart-wrap"><span id="cart_count">{{ $cart_total_item }}</span></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>