{{-- <section class="page-title">
    <div class="auto-container">
        <div class="title-outer text-center">
            <h1 class="title">
                @isset($page_title)
                    {{ $page_title }}
                @endisset
            </h1>
            <ul class="page-breadcrumb">
                <li><a href="/">Home</a></li>
                <li>
                    @isset($page_title)
                        {{ $page_title }}
                    @endisset
               </li>
            </ul>
        </div>
    </div>
</section> --}}

<section>
    <div class="auto-container">
        <div class="section-policies">
            <div class="row">
                <div class="col-md-12">
                   @isset($content->shipping_policy)
                    {!! $content->shipping_policy !!}
                   @endisset
                </div>
            </div>
        </div>
    </div>
</section>
