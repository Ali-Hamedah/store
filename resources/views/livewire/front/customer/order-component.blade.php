<div>
    <div class="d-flex">
        <h2 class="h5 text-uppercase mb-4">{{ __('frontend.orders') }}</h2>
    </div>

    <div class="my-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Ref.</th>
                        <th>{{ __('frontend.total') }}</th>
                        <th>{{ __('frontend.status') }}</th>
                        <th>{{ __('frontend.date') }}</th>
                        <th class="col-2">{{ __('frontend.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr wire:key="{{ $order->id }}">
                            <td>{{ $order->ref_id }}</td>
                            <td>{{ $order->total }} {{ $order->currency_code }}</td>
                            <td>{!! $order->statusWithLabel() !!}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td class="text-right">
                                <button type="button" onclick="displayOrder('{{ $order->id }}')"
                                    class="btn btn-success btn-sm">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <p class="text-center">No orders found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @foreach ($orders as $order)
            <div id="orderDetails{{ $order->id }}" style="display: none;"
                class="order-details border rounded shadow p-4">
                <div class="table-responsive mb-4">
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0" scope="col"><strong
                                        class="text-small text-uppercase">{{ __('frontend.product_name') }}</strong>
                                </th>
                                <th class="border-0" scope="col"><strong
                                        class="text-small text-uppercase">{{ __('frontend.price') }}</strong></th>
                                {{-- <th class="border-0" scope="col"><strong class="text-small text-uppercase">{{__('frontend.discounted_price')}}</strong></th> --}}
                                <th class="border-0" scope="col"><strong
                                        class="text-small text-uppercase">{{ __('frontend.quantity') }}</strong></th>
                                <th class="border-0" scope="col"><strong
                                        class="text-small text-uppercase">{{ __('frontend.total') }}</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $product)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <a href="{{ route('products.show', $product->product->slug) }}">
                                                <img src="{{ $product->product->firstMedia ? asset('assets/products/' . $product->product->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                                    alt="{{ $product->product_name }}" class="img-fluid"
                                                    style="height: 50px; width: 50px; margin-right: 10px; border-radius: 5px; border: 1px solid #ddd;">
                                            </a>
                                            <div>
                                                <a href="{{ route('products.show', $product->product->slug) }}"
                                                    style="font-weight: bold; text-decoration: none;">
                                                    {{ $product->product_name }}
                                                </a>
                                                <br>
                                                <span>
                                                    <em>Color:</em>
                                                    {{ $product->product->variants->first()->color->getTranslation('name', app()->getLocale()) ?? 'No color available' }}
                                                </span>
                                                <br>
                                                <span>
                                                    <em>Size:</em>
                                                    {{ $product->product->variants->first()->size->name }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $product->original_price }}{{ $order->currency_code }}</td>
                                    {{-- <td>{{ $product->discounted_price }}</td> --}}
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->original_price * $product->quantity }}{{ $order->currency_code }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right"><strong>{{ __('frontend.subtotal') }}</strong>
                                </td>
                                <td>{{ $order->total_before_discount }}{{ $order->currency_code }}</td>
                            </tr>
                            @if (!is_null($order->discount))
                                <tr>
                                    <td colspan="3" class="text-right"><strong>{{ __('frontend.discount') }}
                                            (<small>{{ $order->discount }}</small>)</strong></td>
                                    <td>{{ $order->discount }}{{ $order->currency_code }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="text-right"><strong>{{ __('frontend.tax') }}</strong></td>
                                <td>{{ $order->tax }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>{{ __('frontend.shipping') }}</strong>
                                </td>
                                <td>{{ $order->shipping }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>{{ __('frontend.amount') }}</strong></td>
                                <td>{{ $order->total }}{{ $order->currency_code }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2 class="h5 text-uppercase">{{ __('frontend.transactions') }}</h2>
                <div class="table-responsive mb-4">
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0" scope="col"><strong
                                        class="text-small text-uppercase">{{ __('frontend.transaction') }}</strong>
                                </th>
                                <th class="border-0" scope="col"><strong
                                        class="text-small text-uppercase">{{ __('frontend.date') }}</strong></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->status($transaction->transaction) }}</td>
                                    <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if (
                                            $loop->last &&
                                                $transaction->transaction == \App\Models\OrderTransaction::FINISHED &&
                                                \Carbon\Carbon::now()->addDays(5)->diffInDays($transaction->created_at->format('Y-m-d')) != 0)
                                            <button type="button" onclick="requestReturnOrder('{{ $order->id }}')"
                                                class="btn btn-link text-right">
                                                you can return order in
                                                {{ 5 - $transaction->created_at->diffInDays() }} days
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function displayOrder(orderId) {

        const orderDetails = document.getElementById("orderDetails" + orderId);

        if (orderDetails) {

            if (orderDetails.style.display === 'block') {
                orderDetails.style.display = 'none';
            } else {

                const allDetails = document.querySelectorAll('.order-details');
                allDetails.forEach(detail => {
                    detail.style.display = 'none';
                });
                orderDetails.style.display = 'block';
            }
        }
    }

    function requestReturnOrder(orderId) {
        alert('Requesting return for order ID: ' + orderId);
    }
</script>
