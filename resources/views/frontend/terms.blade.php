@extends('frontend.layouts.app')
@section('content')
    <section>
        <div class="auto-container">
            <div class="section-policies">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->get('pooja_language') == 'English')
                            @isset($content->terms_and_conditions)
                                {!! $content->terms_and_conditions !!}
                            @endisset
                        @else
                            @isset($content->terms_and_conditions_hindi)
                                {!! $content->terms_and_conditions_hindi !!}
                            @endisset
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
