<x-front-layout title="Checkout">


    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">checkout</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="#">Shop</a></li>
                        <li>checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!--====== Checkout Form Steps Part Start ======-->

    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <form action="{{ route('checkout') }}" method="post" id="payment-form">
                    @csrf
                <div class="col-lg-8">
                   
                        <div class="checkout-steps-form-style-1">
                            <ul id="accordionExample">
                                <li>
                                    <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="true" aria-controls="collapseThree">Your Personal Details </h6>
                                    <section class="checkout-steps-form-content collapse show" id="collapseThree"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>User Name</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="addr[billing][first_name]"
                                                                placeholder="First Name" />
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="addr[billing][last_name]"
                                                                placeholder="Last Name" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Email Address</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[billing][email]"
                                                            placeholder="Email Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Phone Number</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[billing][phone_number]"
                                                            placeholder="Phone Number" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Mailing Address</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[billing][street_address]"
                                                            placeholder="Mailing Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>City</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[billing][city]" placeholder="City" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Post Code</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[billing][postal_code]"
                                                            placeholder="Post Code" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Region/State</label>
                                                    <div class="select-items">
                                                        <x-form.input name="addr[billing][state]" placeholder="State" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Country</label>
                                                    <div class="form-input form">
                                                        <x-form.select name="addr[billing][country]"
                                                            :options="$countries" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-checkbox checkbox-style-3">
                                                    <input type="checkbox" id="checkbox-3">
                                                    <label for="checkbox-3"><span></span></label>
                                                    <p>My delivery and mailing addresses are the same.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form button">
                                                    <button class="btn" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseFour" aria-expanded="false"
                                                        aria-controls="collapseFour">next
                                                        step</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                                <li>
                                    <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">Shipping Address</h6>
                                    <section class="checkout-steps-form-content collapse" id="collapseFour"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>User Name</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="addr[shipping][first_name]"
                                                                placeholder="First Name" />
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="addr[shipping][last_name]"
                                                                placeholder="Last Name" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Email Address</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[shipping][email]"
                                                            placeholder="Email Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Phone Number</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[shipping][phone_number]"
                                                            placeholder="Phone Number" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Mailing Address</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[shipping][street_address]"
                                                            placeholder="Mailing Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>City</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[shipping][city]"
                                                            placeholder="City" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Post Code</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="addr[shipping][postal_code]"
                                                            placeholder="Post Code" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Region/State</label>
                                                    <div class="select-items">
                                                        <x-form.input name="addr[shipping][state]"
                                                            placeholder="State" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Country</label>
                                                    <div class="form-input form">
                                                        <x-form.select name="addr[shipping][country]"
                                                            :options="$countries" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-payment-option">
                                                    <h6 class="heading-6 font-weight-400 payment-title">Select Delivery
                                                        Option</h6>
                                                    <div class="payment-option-wrapper">
                                                        <div class="single-payment-option">
                                                            <input type="radio" name="shipping" checked
                                                                id="shipping-1">
                                                            <label for="shipping-1">
                                                                <img src="https://via.placeholder.com/60x32"
                                                                    alt="Sipping">
                                                                <p>Standerd Shipping</p>
                                                                <span class="price">$10.50</span>
                                                            </label>
                                                        </div>
                                                        <div class="single-payment-option">
                                                            <input type="radio" name="shipping" id="shipping-2">
                                                            <label for="shipping-2">
                                                                <img src="https://via.placeholder.com/60x32"
                                                                    alt="Sipping">
                                                                <p>Standerd Shipping</p>
                                                                <span class="price">$10.50</span>
                                                            </label>
                                                        </div>
                                                        <div class="single-payment-option">
                                                            <input type="radio" name="shipping" id="shipping-3">
                                                            <label for="shipping-3">
                                                                <img src="https://via.placeholder.com/60x32"
                                                                    alt="Sipping">
                                                                <p>Standerd Shipping</p>
                                                                <span class="price">$10.50</span>
                                                            </label>
                                                        </div>
                                                        <div class="single-payment-option">
                                                            <input type="radio" name="shipping" id="shipping-4">
                                                            <label for="shipping-4">
                                                                <img src="https://via.placeholder.com/60x32"
                                                                    alt="Sipping">
                                                                <p>Standerd Shipping</p>
                                                                <span class="price">$10.50</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="steps-form-btn button">
                                                    <button class="btn" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseThree" aria-expanded="false"
                                                        aria-controls="collapseThree">previous</button>
                                                    <a href="javascript:void(0)" class="btn btn-alt">Save &
                                                        Continue</a>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                                <li>
                                    <h6 class="title collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapsefive" aria-expanded="false"
                                        aria-controls="collapsefive">Payment Info</h6>
                                    <section class="checkout-steps-form-content collapse" id="collapsefive"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="checkout-payment-form">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                            </ul>
                        </div>
                 
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-coupon">
                            <p>Apply Coupon to get discount!</p>
                            <form id="apply-coupon-form">
                                <div id="coupon-response"></div>
                                <input type="text" id="coupon_code" name="coupon_code" placeholder="أدخل الكوبون">
                                <div class="button mt-2">
                                    <button type="button" class="btn btn-primary" id="apply-coupon-btn">Apply Coupon</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="checkout-sidebar-price-table mt-30">
                            <h5 class="title">Pricing Table</h5>

                            <div class="sub-total-price">
                                <div class="total-price">
                                    <p class="value">Subtotal Price:</p>
                                    <p class="price" id="subtotal">{{ Currency::format($cart->total()) }}</p>
                                </div>
                                <div class="total-price shipping">
                                    <input type="hidden" name="discount" value="10"/> 
                                    <p class="value">Discount:</p>
                                    <p class="price" id="discount-amount">{{ Currency::format(00.0) }}</p>
                                </div>
                                <div class="total-price discount">
                                    <input type="hidden" name="shipping"  value="5"/> 
                                    <p class="value" >Shipping:</p>
                                    <p class="price" id="shipping">{{ Currency::format(5.00) }}</p>
                                </div>
                            </div>
                            
                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Total Payable Price:</p>
                                    @php
                                        $totalWithDiscountAndShipping = floatval($cart->total())  + 5.00;
                                    @endphp
                                    <input type="hidden" name="total"  id="paytotal" value="{{ $totalWithDiscountAndShipping }}"/>
                                    <p class="price" id="total">{{ Currency::format($totalWithDiscountAndShipping) }}</p>
                                </div>
                            </div>
                            
                            <div class="single-form form-default button">
                                <button type="submit" id="submit" class="btn">pay
                                    now</button>
                            </div>
                        </div>
                  
                        <div class="checkout-sidebar-banner mt-30">
                            <a href="product-grids.html">
                                <img src="https://via.placeholder.com/400x330" alt="#">
                            </a>
                        </div>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        const csrf_token = "{{ csrf_token() }}"; // تعريف رمز CSRF Token
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const nextButtons = document.querySelectorAll('.btn[data-bs-toggle="collapse"]');

                nextButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        const targetId = button.getAttribute('data-bs-target');
                        const targetElement = document.querySelector(targetId);

                        const currentOpen = document.querySelector('.collapse.show');
                        if (currentOpen) {
                            currentOpen.classList.remove('show');
                        }

                        if (targetElement) {
                            targetElement.classList.add('show');
                        }
                    });
                });
            });
        </script>

<script>
   $(document).ready(function () {
    const csrf_token = "{{ csrf_token() }}"; // تأكد من وجود الـ CSRF Token
    var originalSubtotal = parseFloat($('#subtotal').text().replace(/[^0-9.]/g, '')) || 0;
    var originalshipping = parseFloat($('#shipping').text().replace(/[^0-9.]/g, '')) || 0;
    $('#apply-coupon-btn').on('click', function (e) {
        e.preventDefault();  // منع التحديث التلقائي للصفحة

        let couponCode = $('#coupon_code').val();

        // تحقق إذا كان الكوبون فارغًا
        if (!couponCode) {
            $('#coupon-response').html('<p style="color: red;">من فضلك أدخل الكود</p>');
            return;
        }

        $.ajax({
            url: '/apply-coupon',  // تأكد أن هذا هو المسار الصحيح لتطبيق الكوبون في Laravel
            method: 'POST',
            data: {
                coupon_code: couponCode,
                _token: csrf_token  // تأكد من إرسال الـ CSRF Token
            },
            success: function (response) {
                $('#coupon-response').html(`<p style="color: green;">${response.message}</p>`);
                $('#discount-amount').text(response.discount.toFixed(2));

                // حساب المجموع الكلي بعد الخصم
                var discountAmount = parseFloat(response.discount.toFixed(2)) || 0;
                var originalSubtotal = parseFloat($('#subtotal').text().replace(/[^\d.-]/g, ''));  // استخراج المجموع الكلي قبل الخصم
                var total = originalSubtotal - discountAmount ;
                var total = total + originalshipping ;
                // تحديث المجموع الكلي في الواجهة
                $('#total').text(total.toFixed(2));
                $('#paytotal').val(total.toFixed(2));
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON?.error || 'كوبون غير صالح. يرجى المحاولة مجددًا.';
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
</x-front-layout>
