@extends('frontend.layouts.app')

@section('meta')
    @if (!empty(appSetupValue('app_name')))
        <title>{{ appSetupValue('app_name') }}</title>
    @endif
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection


@section('content')
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">{{ $city }}</h1>
            </div>
        </div>
    </section>

    <section class="featured-products">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                    <div class="one-day-puja mt-5 mt-lg-0">
                        <div class="filter-list">
                            <div class="row">
                                @if ($products->isEmpty())
                                    <div class="not-found">
                                        {{-- <img src="{{ asset('frontend/assets/images/404.png') }}"> --}}
                                        <h1>OPPS! Data is Not Found</h1>
                                        <a href="/" class="theme-btn btn-style-one"><span class="btn-title"><i
                                                    class="far fa-arrow-alt-circle-left"></i>&nbsp;Back Homepage</span></a>
                                    </div>
                            </div>
                        @else
                            @foreach ($products as $product)
                                <div class="col-lg-3 col-6">
                                    <div class="product-block all mix pantry fruit d-block">
                                        <div class="inner-box">
                                            <div class="image">
                                                <a href="{{ route('details', $product->slug) }}"><img
                                                        src="{{ $product->full_image_url }}"
                                                        onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';"></a>
                                            </div>
                                            @if (session()->get('pooja_language') == 'English')
                                                <div class="content">
                                                    <h4 class="text-center"><a
                                                            href="{{ route('details', $product->slug) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <a href="{{ route('details', $product->slug) }}"
                                                        class="theme-btn btn-style-one read-more">Participate <i
                                                            class="far fa-long-arrow-right"></i></a>
                                                </div>
                                            @else
                                                <div class="content">
                                                    <h4 class="text-center"><a
                                                            href="{{ route('details', $product->slug) }}">{{ $product->name_hindi }}</a>
                                                    </h4>
                                                    <a href="{{ route('details', $product->slug) }}"
                                                        class="theme-btn btn-style-one read-more"> भाग लें <i
                                                            class="far fa-long-arrow-right"></i></a>
                                                </div>
                                            @endif
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
@endsection
