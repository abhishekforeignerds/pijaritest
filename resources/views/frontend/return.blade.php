@extends('frontend.layouts.app')
@section('content')

<section>
    <div class="auto-container">
        <div class="section-policies">
            <div class="row">
                <div class="col-md-12">
                    @if (session()->get('pooja_language') == 'English')
                    @isset($content->return_policy)
                        {!! $content->return_policy !!}
                    @endisset
                @else
                    @isset($content->return_policy_hindi)
                        {!! $content->return_policy_hindi !!}
                    @endisset
                @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
