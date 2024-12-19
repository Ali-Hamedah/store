<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items">{{ $items->count() }}</span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ $items->count() }} Items</span>
            <a href="{{ route('cart.index') }}">View Cart</a>
        </div>
        <div class="overflow-auto" style="max-height: 300px;">
            <ul class="list-unstyled shopping-list">
                @foreach($items as $item)
                <li class="d-flex align-items-center border-bottom py-2">
                    <div class="me-3">
                        <a href="{{ route('products.show', $item->product->slug) }}">
                            <img src="{{ $item->product->firstMedia ? asset('assets/products/' . $item->product->firstMedia->file_name) : asset('assets/no_image.jpg') }}" style="width: 50px; height: 50px;">
                        </a>
                    </div>
                    <div>
                        <h6 class="mb-1">
                            <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                        </h6>
                        <small class="text-muted">{{ $item->quantity }}x - {{ Currency::format($item->product->price) }}</small>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="bottom">
            <div class="total">
                <span>Total</span>
                <span class="total-amount">{{ Currency::format($total) }}</span>
            </div>
            <div class="button">
                {{-- <a href="{{ route('checkout') }}" class="btn animate">Checkout</a> --}}
            </div>
        </div>
    </div>
    <!--/ End Shopping Item -->
</div>