<x-front-layout title="Cart">

    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Cart</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            {{-- <li><a href="{{ route('products.index') }}">Shop</a></li> --}}
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">
                            <!-- صورة المنتج -->
                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>{{ __('frontend.product_name') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('frontend.quantity') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('frontend.price') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('frontend.subtotal') }}</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>{{ __('frontend.remove') }}</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->

                @foreach ($cart->get() as $item)
                    <!-- Cart Single List list -->
                    <div class="cart-single-list" id="item-{{ $item->id }}">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="{{ route('products.show', $item->product->slug) }}">
                                    <img src="{{ $item->product->firstMedia ? asset('assets/products/' . $item->product->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                        alt="{{ $item->product->name }}" class="img-fluid"
                                        style="height: 50px; width: 50px; margin-right: 10px; border-radius: 5px; border: 1px solid #ddd;">
                                </a>


                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <a href="{{ route('products.show', $item->product->slug) }}"
                                    style="font-weight: bold; text-decoration: none;">
                                    {{ $item->product->name }}
                                </a>
                                <p class="product-des">
                                    <span><em>Color:</em>
                                        {{ $item->product->variants->first()->color->getTranslation('name', app()->getLocale()) ?? 'No color available' }}</span>
                                    <span><em>Size:</em> {{ $item->product->variants->first()->size->name }}</span>

                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <div class="count-input">
                                    <input type="number" class="form-control item-quantity"
                                        data-id="{{ $item->id }}"
                                        data-stock="{{ $item->product->variants->first()->quantity }}"
                                        value="{{ $item->quantity }}" min="1"
                                        max="{{ $item->product->variants->first()->quantity }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ Currency::format($item->product->price) }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <!-- استخدام class بدل id -->
                                <p class="subtotal">
                                    {{ Currency::format($item->quantity * $item->product->price) }}</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <a class="remove-item" data-id="{{ $item->id }}" href="javascript:void(0)">
                                    <i class="lni lni-close"></i>
                                </a>
                            </div>
                        </div>
                        <div id="error-message" style="color: red; display: none;"></div>
                    </div>

                    <!-- End Single List list -->
                @endforeach
            </div>

            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form id="apply-coupon-form">
                                            <div id="coupon-response"></div>
                                            <input type="text" id="coupon_code" name="coupon_code"
                                                placeholder="{{ __('frontend.enter_coupon') }}">
                                            <div class="button mt-2">
                                                <button id="apply-coupon-button" class="btn btn-primary"
                                                    disabled>{{ __('frontend.apply_coupon') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ __('frontend.cart_subtotal') }}
                                            <span class="cart-total"
                                                id="subtotal">{{ \App\Helpers\Currency::format($cart->total()) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ __('frontend.shipping') }}
                                            <span>Free</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ __('frontend.discount') }}
                                            <span class="cart-discount" id="discount-amount">0.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center"
                                            class="cart-total">
                                            {{ __('frontend.you_pay') }}
                                            <span
                                                id="total">{{ \App\Helpers\Currency::format($cart->total()) }}</span>
                                        </li>
                                    </ul>
                                    <div class="button mt-3">
                                        <a href="{{ route('checkout') }}"
                                            class="btn btn-primary">{{ __('frontend.checkout') }}</a>
                                        <a href="{{ route('frontend.shop') }}"
                                            class="btn btn-secondary">{{ __('frontend.continue_shopping') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>

    <!--/ End Shopping Cart -->

    @push('scripts')
        <script>
            const csrf_token = "{{ csrf_token() }}";
            const couponSuccessMessage = @json(__('frontend.coupon_success'));
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script>
            $(document).ready(function() {

                var originalSubtotal = parseFloat($('#subtotal').text().replace(/[^0-9.]/g, '')) || 0;

                function resetDiscount() {
                    var discountAmount = $('#discount-amount').text().trim();
                    if (discountAmount !== '0.00') {
                        $('#coupon-response').html(
                            '<p style="color: orange;">' + @json(__('frontend.discount_canceled')) + '</p>'
                        );
                    }
                    $('#discount-amount').text('0.00');
                    $('#total').text(originalSubtotal.toFixed(2));
                }

                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'childList') {

                            originalSubtotal = parseFloat($('#subtotal').text().replace(/[^0-9.]/g,
                                '')) || 0;
                            resetDiscount();
                        }
                    });
                });

                const targetNode = document.getElementById('subtotal');
                if (targetNode) {
                    observer.observe(targetNode, {
                        childList: true
                    });
                }

                $('#apply-coupon-form').on('submit', function(e) {
                    e.preventDefault();

                    let couponCode = $('#coupon_code').val();

                    $.ajax({
                        url: '/apply-coupon',
                        method: 'POST',
                        data: {
                            coupon_code: couponCode,
                            _token: csrf_token
                        },

                        success: function(response) {

                            let discountFormatted = response.formatted_discount;
                            let discountValue = parseFloat(discountFormatted.replace(/[^0-9.-]+/g,
                                ''));
                            let greater_than = response.greater_than;


                            if (discountValue === 0) {
                                $('#coupon-response').html(
                                    '<p style="color: blue;">' +
                                    @json(__('frontend.cart_total_limit')) + ' ' + greater_than + '</p>'
                                );
                            } else {

                                $('#coupon-response').html(
                                    `<p style="color: green;">${couponSuccessMessage}</p>`
                                );
                                $('#discount-amount').text(discountFormatted);
                                $('#total').text(response.formatted_new_total);
                                var total = parseFloat(response.formatted_new_total.replace(
                                    /[^0-9.-]+/g, "")) || 0;
                            }
                        },

                        error: function(xhr) {
                            let errorType = xhr.responseJSON?.error_type || 'unknown';
                            let errorMessage = xhr.responseJSON?.error ||
                                ''
                            if (errorType === 'invalid') {
                                $('#coupon-response').html(
                                    `<p style="color: red;">${errorMessage} ${@json(__('frontend.invalid_coupon'))}</p>`
                                );
                            } else if (errorType === 'expired') {
                                $('#coupon-response').html(
                                    `<p style="color: red;">${errorMessage} ${@json(__('frontend.expired_coupon'))}</p>`
                                );
                            } else {
                                $('#coupon-response').html(
                                    `<p style="color: red;">Enter Coupon.</p>`
                                );
                            }

                            // $('#discount-amount').text('0.00');
                            // $('#total').text(originalSubtotal.toFixed(2));
                        }
                    });
                });
            });
        </script>
    @endpush


    @vite('resources/js/cart.js')

</x-front-layout>
