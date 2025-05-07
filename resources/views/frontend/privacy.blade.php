@extends('frontend.layouts.app')
@section('content')

@section('meta')
    <title>Puajri Ji</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

<section>
    <div class="auto-container">
        <div class="section-policies">
            <div class="row">
                <div class="col-md-12">
                    @if (session()->get('pooja_language') == 'English')
                        @isset($content->privacy_policy)
                            {!! $content->privacy_policy !!}
                        @endisset
                    @else
                        @isset($content->privacy_policy_hindi)
                            {!! $content->privacy_policy_hindi !!}
                        @endisset
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
