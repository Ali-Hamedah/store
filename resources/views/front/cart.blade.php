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
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Price</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Remove</p>
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
                                    <img src="{{ $item->product->firstMedia ? asset('assets/products/' . $item->product->firstMedia->file_name) : asset('assets/no_image.jpg')  }}" alt="#" class="img-fluid" style="height: 50px; width: 50px;">
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name">
                                    <a href="{{ route('products.show', $item->product->slug) }}">
                                        {{ $item->product->name }}
                                    </a>
                                </h5>
                                <p class="product-des">
                                    <span><em>Type:</em> Mirrorless</span>
                                    <span><em>Color:</em> {{ $item->product->variants->first()->color->getTranslation('name', app()->getLocale()) ?? 'No color available' }}</span>
                                    <span><em>Size:</em> {{ $item->product->variants->first()->size->name}}</span>

                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <div class="count-input">
                                    <input type="number" class="form-control item-quantity"
                                        data-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ \App\Helpers\Currency::format($item->product->price) }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <!-- استخدام class بدل id -->
                                <p class="subtotal">
                                    {{ \App\Helpers\Currency::format($item->quantity * $item->product->price) }}</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <a class="remove-item" data-id="{{ $item->id }}" href="javascript:void(0)">
                                    <i class="lni lni-close"></i>
                                </a>
                            </div>
                        </div>
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
                                            <input type="text" id="coupon_code" name="coupon_code" placeholder="أدخل الكوبون">
                                            <div class="button mt-2">
                                                <button class="btn btn-primary">Apply Coupon</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Cart Subtotal
                                            <span
                                                class="cart-total" id="subtotal">{{ \App\Helpers\Currency::format($cart->total()) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Shipping
                                            <span>Free</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center"
                                         >
                                         Discount 
                                            <span class="cart-discount" id="discount-amount">00.0</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center"
                                        class="cart-total" >
                                            You Pay
                                            <span id="total"></span>
                                        </li>
                                    </ul>
                                    <div class="button mt-3">
                                        <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
                                        <a href="product-grids.html" class="btn btn-secondary">Continue shopping</a>
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
        const csrf_token = "{{ csrf_token() }}"; // تعريف رمز CSRF Token
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // متغير للاحتفاظ بالمجموع الأساسي (قبل الخصم)
            var originalSubtotal = parseFloat($('#subtotal').text().replace(/[^0-9.]/g, '')) || 0;
        
            // إعادة تعيين الخصم عند تغيير المجموع الفرعي
            function resetDiscount() {
                $('#discount-amount').text('0.00'); // تعيين الخصم إلى 0
                $('#coupon-response').html('<p style="color: orange;">تم إلغاء الخصم بسبب تغيّر قيمة السلة. يرجى إعادة إدخال الكوبون.</p>');
        
                // تحديث المجموع الكلي بالمجموع الفرعي الأساسي
                $('#total').text(originalSubtotal.toFixed(2));
            }
        
            // مراقبة التغييرات في المجموع الفرعي (subtotal)
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.type === 'childList') {
                        // إذا تغير النص في العنصر، أعد تعيين الخصم
                        originalSubtotal = parseFloat($('#subtotal').text().replace(/[^0-9.]/g, '')) || 0;
                        resetDiscount();
                    }
                });
            });
        
            // مراقبة عنصر المجموع الفرعي
            const targetNode = document.getElementById('subtotal');
            if (targetNode) {
                observer.observe(targetNode, { childList: true });
            }
        
            // تطبيق الكوبون
            $('#apply-coupon-form').on('submit', function (e) {
                e.preventDefault();
        
                let couponCode = $('#coupon_code').val();
        
                $.ajax({
                    url: '/apply-coupon', // مسار API في Laravel
                    method: 'POST',
                    data: {
                        coupon_code: couponCode,
                        _token: csrf_token // تأكد من إرسال CSRF Token هنا
                    },
                    success: function (response) {
                        $('#coupon-response').html(`<p style="color: green;">${response.message}</p>`);
                        $('#discount-amount').text(response.discount.toFixed(2));
        
                        // حساب المجموع الكلي بعد الخصم
                        var discountAmount = parseFloat(response.discount.toFixed(2)) || 0;
                        var total = originalSubtotal - discountAmount;
        
                        // تحديث المجموع الكلي في الواجهة
                        $('#total').text(total.toFixed(2));
                    },
                    error: function (xhr) {
                        let errorMessage = xhr.responseJSON?.error || 'كوبون غير صالح. يرجى المحاولة مجددًا.';
                        
                        // إظهار رسالة خطأ واضحة عند فشل الكوبون
                        $('#coupon-response').html(`<p style="color: red;">${errorMessage}</p>`);
        
                        // إعادة ضبط الخصم والمجموع الكلي
                        $('#discount-amount').text('0.00');
                        $('#total').text(originalSubtotal.toFixed(2));
                    }
                });
            });
        });
        </script>
        
    @endpush
    

    @vite('resources/js/cart.js')

</x-front-layout>
