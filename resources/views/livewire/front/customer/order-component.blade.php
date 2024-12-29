<div class="container my-5">
    <div class="d-flex align-items-center mb-4">
        <h2 class="h5 text-uppercase font-weight-bold">{{ __('frontend.orders') }}</h2>
    </div>

    <div class="my-4">
        <div class="table-responsive shadow-sm rounded bg-white">
            <table class="table table-hover">
                <thead class="thead-light">
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
                        <tr wire:key="{{ $order->id }}" class="clickable-row">
                            <td>{{ $order->ref_id }}</td>
                            <td>{{ $order->total }} {{ $order->currency_code }}</td>
                            <td>{!! $order->statusWithLabel() !!}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td class="text-right">
                                <button type="button" onclick="displayOrderDetails('{{ $order->id }}')"
                                    class="btn btn-success btn-sm">
                                    <i class="fa fa-eye"></i> View
                                </button>
                            </td>
                        </tr>
                        <!-- تفاصيل الطلب تظهر أسفل نفس الصف -->
                        <tr id="orderDetails{{ $order->id }}" style="display: none;">
                            <td colspan="5">
                                <div class="order-details mt-4 border rounded shadow p-4 bg-light">
                                    <h4 class="h6 mb-3">{{ __('orders.order_number') }}: {{ $order->number }}</h4>
                                    <div class="table-responsive mb-4">
                                        <table class="table">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-0" scope="col"><strong>{{ __('frontend.product_name') }}</strong></th>
                                                    <th class="border-0" scope="col"><strong>{{ __('frontend.price') }}</strong></th>
                                                    <th class="border-0" scope="col"><strong>{{ __('frontend.quantity') }}</strong></th>
                                                    <th class="border-0" scope="col"><strong>{{ __('frontend.total') }}</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $product)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{ route('products.show', $product->product->slug) }}">
                                                                    <img src="{{ $product->product->firstMedia ? asset('assets/products/' . $product->product->firstMedia->file_name) : asset('assets/no_image.jpg') }}"
                                                                         alt="{{ $product->product_name }}" class="img-fluid"
                                                                         style="height: 50px; width: 50px; margin-right: 10px; border-radius: 5px; border: 1px solid #ddd;">
                                                                </a>
                                                                <div>
                                                                    <a href="{{ route('products.show', $product->product->slug) }}"
                                                                       class="font-weight-bold text-decoration-none">
                                                                        {{ $product->product_name }}
                                                                    </a>
                                                                    <br>
                                                                    <small><em>Color:</em> 
                                                                        {{ $product->product->variants->first()->color->getTranslation('name', app()->getLocale()) ?? 'No color available' }}
                                                                    </small><br>
                                                                    <small><em>Size:</em> {{ $product->product->variants->first()->size->name }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $product->original_price }}{{ $order->currency_code }}</td>
                                                        <td>{{ $product->quantity }}</td>
                                                        <td>{{ $product->original_price * $product->quantity }}{{ $order->currency_code }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="3" class="text-right"><strong>{{ __('frontend.subtotal') }}</strong></td>
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
                                                    <td colspan="3" class="text-right"><strong>{{ __('frontend.shipping') }}</strong></td>
                                                    <td>{{ $order->shipping }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-right"><strong>{{ __('frontend.amount') }}</strong></td>
                                                    <td>{{ $order->total }}{{ $order->currency_code }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                        
                                    <h4 class="h6 text-uppercase mb-3">{{ __('frontend.transactions') }}</h4>
                                    <div class="table-responsive mb-4">
                                        <table class="table">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-0" scope="col"><strong>{{ __('frontend.transaction') }}</strong></th>
                                                    <th class="border-0" scope="col"><strong>{{ __('frontend.date') }}</strong></th>
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
                                                                    You can return order in {{ 5 - $transaction->created_at->diffInDays() }} days
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                        
                                    <!-- Print button added below -->
                                    <div class="text-right">
                                        <button class="btn btn-primary" onclick="printOrderDetails('{{ $order->id }}')">Print</button>
                                    </div>
                        
                                </div>
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
    </div>
</div>

<script>
    function displayOrderDetails(orderId) {
        const orderDetails = document.getElementById("orderDetails" + orderId);
  
        if (orderDetails) {
            orderDetails.style.display = (orderDetails.style.display === 'table-row') ? 'none' : 'table-row';
        }
    }

    function requestReturnOrder(orderId) {
        alert('Requesting return for order ID: ' + orderId);
    }
</script>

<script>
    function printOrderDetails(orderId) {
        // إخفاء زر الطباعة
        document.querySelector(`#orderDetails${orderId} .btn-primary`).style.display = 'none';

        // طباعة التفاصيل باستخدام نافذة الطباعة الخاصة بالجهاز
        var printContent = document.querySelector(`#orderDetails${orderId}`).innerHTML;
        var originalContent = document.body.innerHTML;

        // استبدال محتوى الصفحة بالمحتوى المراد طباعته فقط
        document.body.innerHTML = printContent;

        // استدعاء نافذة الطباعة الخاصة بالجهاز
        window.print();

        // إعادة الصفحة إلى حالتها الأصلية بعد الطباعة
        document.body.innerHTML = originalContent;
    }
</script>


