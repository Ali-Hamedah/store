<x-front-layout title="Cart">
<style>


.home-product-list .single-list {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}


    </style>
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right" dir="ltr">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        <div class="hero-slider">
                            <!-- Start Single Slider -->
                            @foreach ($newProducts as $newProduct)
                                <div class="single-slider">

                                    <img
                                        src="{{ $newProduct->firstMedia ? asset('assets/products/' . $newProduct->firstMedia->file_name) : asset('assets/no_image.jpg') }}">
                                    <div class="content">
                                        <h2><span>No restocking fee ($35 savings)</span>
                                            {{ $newProduct->getTranslation('name', app()->getLocale()) }}
                                        </h2>
                                        <p>{!! substr($newProduct->getTranslation('description', app()->getLocale()), 0, 150) !!}</p>

                                        <div class="price">
                                            <h3><span>Now Only</span>{{ Currency::format( $newProduct->price ) }}
                                                <span class="discount-price"
                                                    style="text-decoration: line-through;"> {{ Currency::format(  $newProduct->compare_price ) }}</span>

                                        </div>
                                        <div class="button">
                                            <a href="{{ route('products.show', $newProduct->slug) }}"
                                                class="btn">{{__('frontend.shop_now')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- End Single Slider -->
                            <!-- Start Single Slider -->
                            {{-- <div class="single-slider"
                                style="background-image: url(https://via.placeholder.com/800x500);">
                                <div class="content">
                                    <h2><span>Big Sale Offer</span>
                                        Get the Best Deal on CCTV Camera
                                    </h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut
                                        labore dolore magna aliqua.</p>
                                    <h3><span>Combo Only:</span> $590.00</h3>
                                    <div class="button">
                                        <a href="product-grids.html" class="btn">Shop Now</a>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- End Single Slider -->
                        </div>
                        <!-- End Hero Slider -->
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner"
                                style="background-image: url('https://via.placeholder.com/370x250');">
                                <div class="content">
                                    <h2>
                                        <span>New line required</span>
                                        iPhone 12 Pro Max
                                    </h2>
                                    <h3>$259.99</h3>
                                </div>
                            </div>
                            <!-- End Small Banner -->
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner style2">
                                <div class="content">
                                    <h2>{{__('frontend.weekly_sale')}}</h2>
                                    <p>{{__('frontend.Saving_up_to')}}</p>
                                    <div class="button">
                                        <a class="btn" href="{{ route('frontend.shop') }}">{{__('frontend.shop_now')}}</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Small Banner -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    <!-- Start Trending Product Area -->
    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{__('frontend.trending_product')}}</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($favorites as $favorite)
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-image">
                                <img src="{{ $favorite->firstMedia ? asset('assets/products/' . $favorite->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                    width="50px" height="150px">


                                <span class="{{ $favorite->discount_percentage ? 'sale-tag' : '' }}">
                                    @if ($favorite->discount_percentage)
                                        -{{ $favorite->discount_percentage }}%
                                    @endif
                                </span>

                                @if ($favorite->is_new)
                                    <span class="new-tag">New</span>
                                @endif

                                <!-- Add Product to Cart Form -->
                                {{-- <form action="{{ route('products.show', $favorite->slug) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" id="product_id" value="{{ $favorite->id }}">
                                    
                                    <input type="hidden" name="quantity" value="{{ 1 }}"> --}}
                                <div class="button">
                                    <button class="btn" style="width: 100%;">
                                        <a href="{{ route('products.show', $favorite->slug) }}">Show Product</a>
                                    </button>
                                </div>

                            </div>
                            <div class="product-info">
                                <span
                                    class="category">{{ $favorite->category->getTranslation('name', app()->getLocale()) }}</span>
                                <h4 class="title">
                                    <a
                                        href="{{ route('products.show', $favorite->slug) }}">{{ $favorite->getTranslation('name', app()->getLocale()) }}</a>
                                </h4>
                                <ul class="review">
                                    @php
                                        $ratingCacheKey = 'product_rating_' . $favorite->id;
                                        $roundedRating = Cache::remember(
                                            $ratingCacheKey,
                                            now()->addMinutes(10),
                                            function () use ($favorite) {
                                                return floor($favorite->averageRating);
                                            },
                                        );
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $roundedRating)
                                            <li><i class="lni lni-star-filled"></i></li>
                                        @else
                                            <li><i class="lni lni-star"></i></li>
                                        @endif
                                    @endfor

                                    <li><span>{{ number_format($favorite->averageRating, 1) }} Review(s)</span></li>
                                </ul>

                                <div class="price">
                                    <span>{{ Currency::format( $favorite->price) }}</span>
                                    <span class="discount-price">{{ Currency::format(  $favorite->compare_price) }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->

    <!-- Start Banner Area -->
    <section class="banner section">
        <div class="container">
            <div class="row">
                @foreach ($favorites->take(2) as $favorite)
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="single-banner"
                            style="background-image: url('{{ $favorite->firstMedia ? asset('assets/products/' . $favorite->firstMedia->file_name) : asset('assets/no_image.jpg') }}'); background-size: cover; background-position: center; height: 340px;">
                            <div class="content">
                                <h2>{{ $favorite->getTranslation('name', app()->getLocale()) }}</h2>
                                <p>{!! substr($favorite->getTranslation('description', app()->getLocale()), 0, 150) !!}</p>
                                <div class="button">
                                    <a href="{{ route('products.show', $favorite->slug) }}" class="btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
   

    <section class="special-offer section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{__('frontend.special_offer')}}</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">

                    <div class="row">
                        @foreach ($discounts as $discount)
                            <div class="col-lg-4 col-md-4 col-12">
                                <!-- Start Single Product -->
                                <div class="single-product">

                                    <div class="product-image">
                                        <img src="{{ $discount->firstMedia ? asset('assets/products/' . $discount->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                            alt="{{ $discount->getTranslation('name', app()->getLocale()) }}">

                                        @if ($discount->discount_percentage)
                                            <span class="sale-tag">-{{ $discount->discount_percentage }}%</span>
                                        @endif
                                        <div class="button">
                                            <button class="btn" style="width: 100%;">
                                                <a href="{{ route('products.show', $favorite->slug) }}">Show
                                                    Product</a>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <span
                                            class="category">{{ $discount->category->getTranslation('name', app()->getLocale()) }}</span>
                                        <h4 class="title">
                                            <a
                                                href="{{ route('products.show', $discount->slug) }}">{{ $discount->getTranslation('name', app()->getLocale()) }}</a>
                                        </h4>
                                        @php
                                            $ratingCacheKey = 'product_rating_' . $discount->id;
                                            $roundedRating = Cache::remember(
                                                $ratingCacheKey,
                                                now()->addMinutes(10),
                                                function () use ($discount) {
                                                    return floor($discount->averageRating);
                                                },
                                            );
                                        @endphp

                                        <ul class="review">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $roundedRating)
                                                    <li><i class="lni lni-star-filled"></i></li>
                                                @else
                                                    <li><i class="lni lni-star"></i></li>
                                                @endif
                                            @endfor
                                            <li><span>{{ number_format($discount->averageRating, 1) }} Review(s)</span>
                                            </li>
                                        </ul>
                                        <div class="price">
                                            <span>{{ Currency::format( $discount->price  ) }}</span>
                                            @if ($discount->compare_price)
                                                <span class="discount-price">{{ Currency::format( $discount->price  ) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Product -->
                            </div>
                        @endforeach
                    </div>
                    <!-- Start Banner -->
                    {{-- @if (!empty($banner))
                        <div class="single-banner right"
                            style="background-image:url('{{ $banner->getImageUrl() }}'); margin-top: 30px;">
                            <div class="content">
                                <h2>{{ $banner->discount('title', app()->getLocale()) }}</h2>
                                <p>{{ $banner->getTranslation('description', app()->getLocale()) }}</p>
                                <div class="price">
                                    <span>${{ $banner->price }}</span>
                                </div>
                                <div class="button">
                                    <a href="{{ route('banner.link', $banner->slug) }}" class="btn">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    @endif --}}
                    <!-- End Banner -->
                </div>

                <div class="col-lg-4 col-md-12 col-12">
                    <div class="offer-content">
                        <div class="image">
                            <img
                                src="{{ optional($bigOffer)->firstMedia ? asset('assets/products/' . optional($bigOffer->firstMedia)->file_name) : asset('assets/no_image.jpg') }}">

                            <span
                                class="sale-tag">{{ round((($bigOffer->compare_price - $bigOffer->price) / $bigOffer->compare_price) * 100) }}-%</span>
                        </div>
                        <div class="text">
                            @if ($bigOffer)
                                <h2>
                                    <a href="{{ route('products.show', $bigOffer->slug) }}">
                                        {{ $bigOffer->getTranslation('name', app()->getLocale()) }}
                                    </a>
                                </h2>
                            @else
                                <p>No offer available at the moment.</p>
                            @endif

                            @php

                                $ratingCacheKey = 'bigOffer_rating_' . $bigOffer->id;
                                $roundedRating = Cache::remember(
                                    $ratingCacheKey,
                                    now()->addMinutes(10),
                                    function () use ($bigOffer) {
                                        return floor($bigOffer->averageRating);
                                    },
                                );
                            @endphp
                            <ul class="review">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $roundedRating)
                                        <li><i class="lni lni-star-filled"></i></li>
                                    @else
                                        <li><i class="lni lni-star"></i></li>
                                    @endif
                                @endfor
                                <li><span>{{ number_format($bigOffer->averageRating, 1) }} Review(s)</span>
                                </li>
                            </ul>
                            <div class="price">
                                <span>{{ Currency::format(  $bigOffer->price  ) }}<</span>
                                <span class="discount-price">{{ Currency::format(  $bigOffer->compare_price ) }}</span>
                            </div>
                            <p>{!! substr($bigOffer->getTranslation('description', app()->getLocale()), 0, 150) !!}</p>

                        </div>
                        <div class="box-head">
                            <div class="box">
                                <h1 id="days">000</h1>
                                <h2 id="daystxt">Days</h2>
                            </div>
                            <div class="box">
                                <h1 id="hours">00</h1>
                                <h2 id="hourstxt">Hours</h2>
                            </div>
                            <div class="box">
                                <h1 id="minutes">00</h1>
                                <h2 id="minutestxt">Minutes</h2>
                            </div>
                            <div class="box">
                                <h1 id="seconds">00</h1>
                                <h2 id="secondstxt">Secondes</h2>
                            </div>
                        </div>
                        <div style="background: rgb(204, 24, 24);">
                            <h1 style="padding: 50px 80px;color: white;">{{ __('frontend.bigoffer_message') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Start Home Product List -->
    <section class="home-product-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12 custom-responsive-margin">
                    <h4 class="list-title">{{__('frontend.best_sellers')}}</h4>
                    <!-- Start Single List -->
                    @foreach ($favorites->take(3) as $favorite)
                        <div class="single-list">
                            <div class="list-image">
                                <img src="{{ $favorite->firstMedia ? asset('assets/products/' . $favorite->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                    width="50px" height="50px">
                            </div>
                            <div class="list-info">
                                <h3>
                                    <a
                                        href="{{ route('products.show', $favorite->slug) }}">{{ $favorite->getTranslation('name', app()->getLocale()) }}</a>
                                </h3>
                                <span>{{ Currency::format( $favorite->price) }}</span>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Single List -->
                </div>
                <div class="col-lg-4 col-md-4 col-12 custom-responsive-margin">
                    <h4 class="list-title">{{__('frontend.new_arrivals')}}</h4>
                    <!-- Start Single List -->
                    @foreach ($newProducts->take(3) as $newProduct)
                        <div class="single-list">
                            <div class="list-image">
                                <img src="{{ $newProduct->firstMedia ? asset('assets/products/' . $newProduct->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                    width="50px" height="50px">

                            </div>
                            <div class="list-info">
                                <h3>
                                    <a
                                        href="{{ route('products.show', $newProduct->slug) }}">{{ $newProduct->getTranslation('name', app()->getLocale()) }}</a>
                                </h3>
                                <span>{{ Currency::format( $newProduct->price) }}</span>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Single List -->

                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <h4 class="list-title">{{__('frontend.top_rated')}}</h4>
                    <!-- Start Single List -->
                    @foreach ($topRatedProducts as $topRatedProduct)
                        <div class="single-list">
                            <div class="list-image">
                                <img src="{{ $topRatedProduct->firstMedia ? asset('assets/products/' . $topRatedProduct->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                    width="50px" height="50px">
                            </div>
                            <div class="list-info">
                                <h3>
                                    <a
                                        href="{{ route('products.show', $topRatedProduct->slug) }}">{{ $topRatedProduct->getTranslation('name', app()->getLocale()) }}</a>
                                </h3>
                                <span>{{ Currency::format( $topRatedProduct->price) }}</span>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Single List -->

                </div>
            </div>
        </div>
    </section>
    <!-- End Home Product List -->

    <!-- Start Brands Area -->
    <div class="brands">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-12">
                    <h2 class="title">{{__('frontend.popular_brands')}}</h2>
                </div>
            </div>
            <div class="brands-logo-wrapper">
                <div class="brands-logo-carousel d-flex align-items-center justify-content-between">
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="#">
                    </div>
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="#">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Brands Area -->
    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Free Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>{{__('frontend.free_shipping')}}</h5>
                        <span>On order over $99</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 {{__('frontend.support')}}.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>{{__('frontend.online_Payment')}}.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>{{__('frontend.easy_return')}}.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- End Shipping Info -->

   
</x-front-layout>
