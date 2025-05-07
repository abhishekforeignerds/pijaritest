@extends('frontend.layouts.app')
@section('content')
    <div class="breadcrumb_sticky">
        <div class="container-fluid p-0">
            @if (session()->get('pooja_language') == 'English')
            <ul class="page-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blogs</a></li>
                <li class="breadcrumb-item">{{ $blog->title }}</li>
            </ul>
            @else
            <ul class="page-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">मुखपृष्ठ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">ब्लॉग्स</a></li>
                <li class="breadcrumb-item">{{ $blog->title_hindi }}</li>
            </ul>
            @endif
        </div>
    </div>
    <div class="auto-container">
        <div class="row">
            <div class="col-md-12">
                <div class="blog-details__left">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="blog-details__img">
                                <img src="{{ $blog->full_image_url }}"
                                    onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/resource/news-1.jpg') }}'">
                            </div>
                        </div>
                        <div class="col-lg-12 col-12">
                            @if (session()->get('pooja_language') == 'English')
                            <h3>{{ $blog->title }}</h3>
                            {!! $blog->description !!}
                            @else
                            <h3>{{ $blog->title_hindi }}</h3>
                            {!! $blog->description_hindi !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
