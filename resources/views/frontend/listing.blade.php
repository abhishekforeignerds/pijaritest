@extends('frontend.layouts.app')
@section('content')

@section('meta')
    <title>Puajri Ji</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection
<section class="featured-products">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="shop-sidebar">
                    <div class="sidebar-widget category-widget">
                        <div class="widget-title">
                            <h5>  @if(session()->get('pooja_language')=='English')  <h5>Categories</h5> @else  <h5>श्रेणियाँ</h5> @endif</h5>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                @foreach (App\Models\Category::where('status', 1)->get() as $category)
                                    <li><a
                                            href="{{ route('listing') }}?category={{ $category->slug }}">@if (session()->get('pooja_language') == 'English'){{ $category->name }}@else {{ $category->name_hindi }} @endif</a>
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
                                        <div class="content">
                                            <h4>
                                                <a href="{{ route('details', $product->slug) }}"> @if(session()->get('pooja_language')=='English') {{ $product->name }} @else {{ $product->name_hindi }} @endif</a>
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
</section>
@endsection
