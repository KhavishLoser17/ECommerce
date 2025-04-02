@extends('layouts.app')
@section('content')
<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
      <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
        <div class="aside-header d-flex d-lg-none align-items-center">
          <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
          <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
        </div>

        <div class="pt-4 pt-lg-0"></div>

        <div class="w-full">
            <!-- Product Categories Filter -->
<div class="mb-4 pb-3 border-b">

    <div id="accordion-filter-1" class="hidden border-0">
        <div class="px-0 pb-0 pt-3">
            <ul class="space-y-2">
                {{-- @foreach($categories as $category)
                <li>
                    <a href="{{ route('shop.index', ['category' => $category]) }}"
                       class="block py-1 {{ request('category') == $category ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600' }}">
                        {{ $category }}
                    </a>
                </li>
                @endforeach --}}
                <li>
                    {{-- <a href="{{ route('shop.index') }}" class="block py-1 text-gray-700 hover:text-blue-600"> --}}
                        <strong>Show All</strong>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>



      <div class="shop-list flex-grow-1">
        <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" data-settings='{
            "autoplay": {
              "delay": 4000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #1e88e5;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2 text-white">
                      <strong> Bestlink College of The<br />Philippines</strong></h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5 text-white text-xl">"Proper uniform, proper mindset — Be trained to be the best. Be linked to success.".</h6>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="{{asset('images/bg-menu/bg1.jpg')}}" width="630" height="450"
                      alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #1e88e5;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2 text-white">
                      <strong>Vision</strong></h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5 text-white text-xl">Bestlink College of the Philippines is committed to provide and promote quality education with a unique, modern and research-based curriculum with
                        delivery system geared towards excellence.</h6>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="{{asset('images/bg-menu/bg10.jpg')}}" width="630" height="450"
                      alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #1e88e5;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2
                      class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2 text-white">
                    <strong>Mission</strong></h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5 text-white text-xl">To produce self motivated and self-directed individuals who aim for academic excellence,
                        God-fearing, peaceful, healthy, productive and successful citizens.</h6>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="{{asset('images/bg-menu/bg5.jpg')}}" width="630" height="450"
                      alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container p-3 p-xl-5">
            <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2"></div>

          </div>
        </div>

        <div class="mb-3 pb-2 pb-xl-3"></div>

       


        <div class="products-grid row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="products-grid">
            {{-- @foreach ($products as $product)
                <div class="product-card-wrapper col">
                    <div class="product-card p-3 shadow-lg rounded-lg">
                        <div class="pc__img-wrapper">
                            <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="{{ asset('storage/' . $product->main_image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $product->main_image) }}"
                                                 alt="{{ $product->product_name }}"
                                                 class="w-100 h-auto object-cover rounded-lg">
                                        </a>

                                    </div>
                                    <a href="{{ route('details.fetch', ['id' => $product->id]) }}"
                                        class="pc__atc btn btn-lg anim_appear-bottom position-absolute border-0 text-uppercase fw-medium">
                                        View Details
                                     </a>
                                </div>
                            </div>
                        </div>



                        <div class="pc__info position-relative text-center mt-3">
                            <p class="pc__category text-muted">{{ $product->category }}</p>
                            <h6 class="pc__title fw-bold text-dark">{{ $product->product_name }}</h6>
                            <div class="product-card__price d-flex justify-content-center">
                                <span class="money price fs-5 fw-bold">₱{{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="product-card__review d-flex justify-content-center align-items-center mt-2">
                                <div class="reviews-group d-flex">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_star" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach --}}
        </div>


        <nav class="shop-pages d-flex justify-content-between mt-3" aria-label="Page navigation">
            {{-- @if ($products->onFirstPage())
                <span class="btn-link d-inline-flex align-items-center text-muted">
                    <svg class="me-1" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_sm" />
                    </svg>
                    <span class="fw-medium">PREV</span>
                </span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="btn-link d-inline-flex align-items-center">
                    <svg class="me-1" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_sm" />
                    </svg>
                    <span class="fw-medium">PREV</span>
                </a>
            @endif

            <ul class="pagination mb-0">
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <li class="page-item">
                        <a
                            class="btn-link px-1 mx-2 {{ $page == $products->currentPage() ? 'btn-link_active' : '' }}"
                            href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach
            </ul>

            @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="btn-link d-inline-flex align-items-center">
                    <span class="fw-medium me-1">NEXT</span>
                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_sm" />
                    </svg>
                </a>
            @else
                <span class="btn-link d-inline-flex align-items-center text-muted">
                    <span class="fw-medium me-1">NEXT</span>
                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_sm" />
                    </svg>
                </span>
            @endif --}}
        </nav>

      </div>
    </section>
  </main>
  <script>
    function toggleAccordion(id) {
        const content = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);

        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const priceRange = document.getElementById('price-range');
    const minPriceDisplay = document.getElementById('min-price-display');
    const maxPriceDisplay = document.getElementById('max-price-display');
    const minPriceInput = document.getElementById('min-price-input');
    const maxPriceInput = document.getElementById('max-price-input');

    if (priceRange) {
        priceRange.addEventListener('input', function() {
            const value = this.value;
            // You can adjust the minimum price or keep it fixed
            minPriceInput.value = 0;
            maxPriceInput.value = value;
            minPriceDisplay.textContent = '₱' + minPriceInput.value;
            maxPriceDisplay.textContent = '₱' + value;
        });
    }

    // Auto-open accordions if they contain active filters
    if (window.location.search.includes('category=')) {
        document.getElementById('accordion-filter-1').classList.remove('hidden');
        document.getElementById('icon-accordion-filter-1').classList.add('rotate-180');
    }

    if (window.location.search.includes('size=')) {
        document.getElementById('accordion-filter-size').classList.remove('hidden');
        document.getElementById('icon-accordion-filter-size').classList.add('rotate-180');
    }

    if (window.location.search.includes('min_price=') || window.location.search.includes('max_price=')) {
        document.getElementById('accordion-filter-price').classList.remove('hidden');
        document.getElementById('icon-accordion-filter-price').classList.add('rotate-180');
    }
});
</script>
@endsection

