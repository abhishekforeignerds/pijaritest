@extends('frontend.layouts.app')

{{-- @section('meta')
<title>Pujariji</title>
<meta name="description" content="">
<meta name="keywords" content="">
@endsection --}}
@section('title', 'Book Your E-Puja Online | Pujariji')
@section('meta_description', 'Participate in spiritual e-pujas from the comfort of your home. Book your puja today with
verified priests.')




@section('content')
<section class="featured-products">
    <div class="auto-container">
        <div class="row clearfix">

            {{-- Sidebar --}}
            <div class="col-lg-3 col-md-12 mobile-col-category-div">
                <div class="shop-sidebar sticky-sidebar">

                    <select id="locationFilterss"
                        class="mt-2 mb-4 select-input-form js-example-basic-single w-100 mb-5">
                        <option value="both">{{ session('pooja_language')=='English' ? 'Select Location' : 'स्थान चयन
                            करें'
                            }}</option>
                        <option value="both">{{ session('pooja_language')=='English' ? 'Both' : 'दोनों' }}</option>
                        <option value="offline">{{ session('pooja_language')=='English' ? 'At my Home' : 'मेरे घर
                            पर' }}</option>
                        <option value="online">{{ session('pooja_language')=='English' ? 'Online' : 'ऑनलाइन' }}
                        </option>
                    </select>
                    {{-- Search (JS-only) --}}
                    <form id="pooja-search-form" class="mt-4 mb-4" onsubmit="return false;">
                        <input type="text" id="pooja-search" class="form-control"
                            placeholder="{{ session('pooja_language')=='English' ? 'Search Poojas...' : 'पूजाओं में खोजें...' }}">
                    </form>

                    {{-- Categories --}}
                    <div class="sidebar-widget category-widget mobile-filter-panel">
                        <div class="widget-title">
                            <h5>
                                {{ session('pooja_language')=='English' ? 'Categories' : 'श्रेणियाँ' }}
                            </h5>
                        </div>
                        <div class="widget-content">
                            <div class="accordion my-4" id="categoryAccordion">
                                {{-- “All Categories” panel --}}
                                @php $allList = $allProducts->flatten(); @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-all">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse-all"
                                            aria-expanded="false">
                                            {{ session('pooja_language')=='English' ? 'All Categories' : 'सभी श्रेणियाँ'
                                            }}
                                        </button>
                                    </h2>
                                    <div id="collapse-all" class="accordion-collapse collapse"
                                        data-bs-parent="#categoryAccordion">
                                        <div class="accordion-body p-2">
                                            <ul class="list-unstyled mb-0">
                                                @foreach($allList as $p)
                                                <li class="mb-1">
                                                    <a href="{{ route('details',$p->slug) }}" class="product-link">
                                                        <i class="fa fa-angle-right me-1"></i>
                                                        {{ session('pooja_language')=='English' ? $p->name :
                                                        $p->name_hindi }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- each real category --}}
                                @foreach($categories as $category)
                                @php $plist = $allProducts[$category->slug] ?? collect(); @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $category->slug }}">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse-{{ $category->slug }}"
                                            aria-expanded="false">
                                            {{ session('pooja_language')=='English' ? $category->name :
                                            $category->name_hindi }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $category->slug }}" class="accordion-collapse collapse"
                                        data-bs-parent="#categoryAccordion">
                                        <div class="accordion-body p-2">
                                            <ul class="list-unstyled mb-0">
                                                @forelse($plist as $p)
                                                <li class="mb-1">
                                                    <a href="{{ route('details',$p->slug) }}" class="product-link">
                                                        <i class="fa fa-angle-right me-1"></i>
                                                        {{ session('pooja_language')=='English' ? $p->name :
                                                        $p->name_hindi }}
                                                    </a>
                                                </li>
                                                @empty
                                                <li class="text-muted">No products.</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Pooja Grid --}}
            <div class="col-lg-9 col-md-12 content-side">
                <div class="mixitup-gallery mt-5 mt-lg-0">
                    @if($products->isEmpty())
                    <div class="not-found text-center">
                        <h1>OPPS! {{ session('pooja_language')=='English' ? 'Pooja Not Found' : 'पूजा नहीं मिली' }}</h1>
                        <a href="/" class="theme-btn btn-style-one">
                            <span class="btn-title">
                                <i class="far fa-arrow-alt-circle-left"></i>
                                {{ session('pooja_language')=='English' ? 'Back Homepage' : 'मुखपृष्ठ पर लौटें' }}
                            </span>
                        </a>
                    </div>
                    @else
                    <div class="filter-container wow fadeInUp">





                    </div>

                    <div class="row" id="pooja-grid">
                        @foreach($products as $product)
                        @php
                        $maxPrice = $product->packages_min_discount_price ?? 0;
                        $minPrice = $product->packages_max_discount_price ?? 0;
                        @endphp
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4 pooja-card"
                            data-category="{{ $product->category->slug }}"
                            data-location="{{ strtolower($product->location_type) }}"
                            data-name="{{ strtolower($product->name) }}"
                            data-name-hindi="{{ strtolower($product->name_hindi) }}">


                            <div class="product-block d-block">
                                <div class="inner-box">
                                    <div class="image">
                                        <a href="{{ route('details', $product->slug) }}">
                                            <img src="{{ $product->full_image_url }}"
                                                onerror="this.src='{{ asset('frontend/pujari/placeholder.jpeg') }}';"
                                                alt="{{ session('pooja_language')=='English' ? $product->name : $product->name_hindi }}">
                                        </a>
                                    </div>

                                    <!-- add a new “product-header” class to handle the flex layout -->
                                    <div class="product-header">
                                        <h4 class="product-title">
                                            <a href="{{ route('details', $product->slug) }}">
                                                {{ session('pooja_language')=='English' ? $product->name :
                                                $product->name_hindi }}
                                            </a>
                                        </h4>
                                        @if ($maxPrice > $minPrice)
                                        <h6 class="product-price">
                                            <strong>Price :</strong> ₹{{ $minPrice }} – ₹{{ $maxPrice }}
                                        </h6>
                                        @else
                                        <h6 class="product-price">
                                            <strong>Price :</strong> ₹{{ $minPrice }}
                                        </h6>
                                        @endif
                                    </div>

                                    <!-- add a little margin-top here so it sits nicely under the row above -->
                                    <div class="theme-primary-btn my-4">
                                        <a href="{{ route('details', $product->slug) }}"
                                            class="theme-btn btn-style-one">
                                            <span class="btn-title">BOOK NOW <i
                                                    class="far fa-long-arrow-alt-right"></i></span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @endif
                </div>
                <script>
                    document.querySelectorAll('.accordion-collapse').forEach(collapseEl => {
                      collapseEl.addEventListener('shown.bs.collapse', function(){
                  
                        const id       = this.id;               // e.g. "collapse-shloka"
                        const slug     = id.replace('collapse-','');
                        const grid     = document.getElementById('pooja-grid');
                        const cards    = Array.from(grid.querySelectorAll('.pooja-card'));
                        const allCount = cards.length;
                        let shownCards, hiddenCards;
                  
                        if(id === 'collapse-all') {
                          // show all
                          cards.forEach(c => c.style.display = '');
                          shownCards = cards;
                          hiddenCards = [];
                        } else {
                          // show only matching slug
                          shownCards  = cards.filter(c => c.dataset.category === slug);
                          hiddenCards = cards.filter(c => c.dataset.category !== slug);
                          shownCards.forEach(c => c.style.display = '');
                          hiddenCards.forEach(c => c.style.display = 'none');
                        }
                  
                        // DEBUG OUTPUT
                        console.group(`Accordion opened: "${id}"`);
                        console.log(`Slug = "${slug}"`);
                        console.log(`Total cards: ${allCount}`);
                        console.log(`→ Shown (${shownCards.length}):`, shownCards.map(c=>c.dataset.category+' / '+c.dataset.name));
                        console.log(`→ Hidden (${hiddenCards.length}):`, hiddenCards.map(c=>c.dataset.category+' / '+c.dataset.name));
                        console.groupEnd();
                  
                      });
                    });
                </script>

            </div>

        </div>
    </div>
</section>


{{-- Video Testimonials (unchanged) --}}
@if(count($video_testimonials) > 0)
<section class="video-testimonial-section service-section-three pujariji-background">
    <div class="auto-container">
        <div class="sec-title wow fadeInUp">
            <h1>
                {{ session('pooja_language')=='English' ? 'Testimonials' : 'समीक्षाएं' }}
                <span>
                    {{ session('pooja_language')=='English' ? 'VIDEO FEEDBACK' : 'वीडियो प्रतिक्रिया' }}
                </span>
            </h1>
        </div>
        <div class="carousel-outer">
            <div class="swiper video-testimonial">
                <div class="swiper-wrapper">
                    @foreach ($video_testimonials as $test)
                    <div class="swiper-slide">
                        <iframe width="100%" class="ytb" src="{{ $test->link }}?modestbranding=1&controls=0"
                            allowfullscreen></iframe>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@endsection