<x-FrontLayout :title="$product->name">
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <div id="mainImageCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($product->media->sortBy('id') as $index => $media)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('assets/products/' . $media->file_name) }}"
                                                class="d-block w-100" alt="Product Image">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#mainImageCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#mainImageCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <div class="thumbnail-images mt-3 d-flex justify-content-center">
                                @foreach ($product->media->sortBy('id')->take(5) as $index => $media)
                                    <div class="thumb-container mx-1">
                                        <img src="{{ asset('assets/products/' . $media->file_name) }}"
                                            class="img-thumbnail thumb-img" alt="Thumbnail Image"
                                            onclick="changeImage(this, {{ $index }})"
                                            id="thumb-{{ $index }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <h2 class="title">{{ $product->getTranslation('name', app()->getLocale()) }}</h2>
                            <p class="category"><i class="lni lni-tag"></i> {{ __('frontend.tags') }}:
                                @foreach ($product->tags as $tag)
                                    <a href="{{ route('frontend.shop', $tag->slug) }}">{{ $tag->slug }}</a>
                                @endforeach
                            </p>
                            <h3 class="price">{{ Currency::format($product->price) }} @if ($product->compare_price)
                                    <span>{{ Currency::format($product->compare_price) }}</span>
                                @endif
                            </h3>
                            <p class="info-text">{!! substr($product->getTranslation('description', app()->getLocale()), 0, 150) !!}</p>

                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group color-option">
                                            <label>{{ __('frontend.color') }}</label>
                                            <select name="color_id" id="colorSelect" class="form-control" required>
                                                <option>{{ __('frontend.choose') }} {{ __('frontend.color') }}
                                                </option>
                                                @foreach ($colors as $index => $color)
                                                    <option value="{{ $color->color_id }}"
                                                        @if ($index === 0) selected @endif>
                                                        {{ $color->color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group size-option">
                                            <label>{{ __('frontend.size') }}</label>
                                            <select name="size_id" id="sizeSelect" class="form-control" required>
                                                <option value="">{{ __('frontend.choose') }}
                                                    {{ __('frontend.size') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group quantity">
                                            <label for="quantity">{{ __('frontend.quantity') }}</label>
                                            <select class="form-control" id="quantity" name="quantity">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="coupon-response"></div>
                                <div class="bottom-content">
                                    <div class="row align-items-end">
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="button cart-button">
                                                <button type="submit" class="btn"
                                                    style="width: 100%;">{{ __('frontend.add_to_cart') }}</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="wish-button">
                                                <button type="button" class="btn"><i class="lni lni-reload"></i>
                                                    Compare</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="wish-button">
                                                <button type="button" class="btn"><i class="lni lni-heart"></i>
                                                    {{ __('frontend.add_to_wishlist') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>{{ __('frontend.details') }}</h4>

                                <h7>{!! $product->getTranslation('description', app()->getLocale()) !!}</h7>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="single-block">
                            <div class="reviews" id="latest_review">
                                <h4 class="title">{{ __('frontend.latest_reviews') }}</h4>

                                @foreach ($reviews as $key => $review)
                                    <div class="single-review review-item" data-index="{{ $key }}"
                                        style="{{ $key >= 3 ? 'display: none;' : '' }}">
                                        <img src="https://via.placeholder.com/150x150" alt="#">
                                        <div class="review-info">
                                            <h4>{{ $review->title }}
                                                <span>{{ $review->name }}</span>
                                            </h4>
                                            <ul class="stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                    @else
                                                        <li><i class="lni lni-star"></i></li>
                                                    @endif
                                                @endfor
                                            </ul>
                                            <p>{{ $review->message }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($reviews->count() > 3)
                                    <div class="text-center">
                                        <button id="load-more"
                                            class="btn btn-primary">{{ __('frontend.load_more') }}</button>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="single-block give-review">
                        <h4>{{ number_format($averageRating, 1) }} (Overall)</h4>
                        <ul>
                            <li>
                                <span>5 stars - {{ $fiveStars }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="lni lni-star{{ $i < 5 ? '-filled' : '' }}"></i>
                                @endfor
                            </li>
                            <li>
                                <span>4 stars - {{ $fourStars }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="lni lni-star{{ $i < 4 ? '-filled' : '' }}"></i>
                                @endfor
                            </li>
                            <li>
                                <span>3 stars - {{ $threeStars }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="lni lni-star{{ $i < 3 ? '-filled' : '' }}"></i>
                                @endfor
                            </li>
                            <li>
                                <span>2 stars - {{ $twoStars }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="lni lni-star{{ $i < 2 ? '-filled' : '' }}"></i>
                                @endfor
                            </li>
                            <li>
                                <span>1 star - {{ $oneStar }}</span>
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="lni lni-star{{ $i < 1 ? '-filled' : '' }}"></i>
                                @endfor
                            </li>
                        </ul>
                        @if (Auth::check())
                            @if (!$userReview)
                                <button type="button" class="btn review-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Leave a Review
                                </button>
                            @endif
                        @else
                            <div class="alert alert-warning" role="alert">
                                {{ __('frontend.you_must_log') }}<a href="{{ route('choose.login') }}"
                                    class="alert-link">{{ __('frontend.click_here_to_login') }}</a>.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Review Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Leave a Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-subject">Subject</label>
                                    <input class="form-control" type="text" id="title" name="title"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="review-rating">Rating</label>
                                    <select class="form-control" id="rating" name="rating" required>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            <label for="review-message">Review</label>
                            <textarea class="form-control" id="message" name="message" rows="8" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- End Review Modal -->
    <!-- End Item Details -->

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function changeImage(image, index) {
                const mainImage = document.querySelector('#mainImageCarousel .carousel-item.active img');
                mainImage.src = image.src;
                const thumbnails = document.querySelectorAll('.thumb-img');
                thumbnails.forEach((thumb, i) => {
                    thumb.style.opacity = i === index ? '0.5' : '1';
                });
            }
        </script>

        <script>
            $(document).ready(function() {

                $('#colorSelect').on('change', function() {
                    var colorId = $(this).val();
                    var productId = $('#product_id').val();

                    $.ajax({
                        url: '/get-sizes/' + colorId,
                        method: 'GET',
                        data: {
                            product_id: productId,
                        },
                        success: function(response) {

                            $('#sizeSelect').empty();
                            $('#sizeSelect').append(
                                '<option value="">{{ __('frontend.choose') }} {{ __('frontend.size') }}</option>'
                            );

                            $.each(response, function(index, size) {
                                $('#sizeSelect').append('<option value="' + size.id +
                                    '" data-quantity="' + size.quantity + '">' + size
                                    .name + '</option>');
                            });

                            $('#coupon-response').html('');
                        },
                        error: function() {
                            alert('حدث خطأ في جلب المقاسات!');
                        }
                    });
                });

                $('#sizeSelect').on('change', function() {
                    var selectedOption = $(this).find(':selected');
                    var quantity = selectedOption.data('quantity');
                    var sizeName = selectedOption.text();

                    if (quantity !== undefined && quantity < 10) {
                        $('#coupon-response').html(
                            '<p style="color: red; font-size: 12px; font-weight: bold;">' + sizeName + ' ' +
                            @json(__('frontend.quantity_stock')) + ' (' + quantity + ') ' + '</p>'
                        );
                    } else {
                        $('#coupon-response').html('');
                    }
                });

            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const loadMoreBtn = document.getElementById('load-more');
                const reviewItems = document.querySelectorAll('.review-item');
                let visibleCount = 3; // 

                loadMoreBtn.addEventListener('click', function() {
                    const reviewsToShow = Array.from(reviewItems).slice(visibleCount, visibleCount +
                        3);
                    reviewsToShow.forEach(review => review.style.display = 'block');
                    visibleCount += 3;

                    if (visibleCount >= reviewItems.length) {
                        loadMoreBtn.style.display = 'none';
                    }
                });
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @endpush

</x-FrontLayout>
