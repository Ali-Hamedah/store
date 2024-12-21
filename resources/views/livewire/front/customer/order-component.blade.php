<div>
    <div class="d-flex">
        <h2 class="h5 text-uppercase mb-4">Orders</h2>
    </div>

    <div class="my-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Order Ref.</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="col-2">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr wire:key="{{ $order->id }}">
                        <td>{{ $order->ref_id }}</td>
                        <td>{{ \App\Helpers\Currency::format($order->total) }}</td>
                        <td>{!! $order->statusWithLabel() !!}</td>
                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                        <td class="text-right">
                            <button type="button" onclick="displayOrder('{{ $order->id }}')" class="btn btn-success btn-sm">
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

        @foreach($orders as $order)
            <div id="orderDetails{{ $order->id }}" style="display: none;" class="order-details border rounded shadow p-4">
                <div class="table-responsive mb-4">
                    <table class="table">
                        <thead class="bg-light">
                        <tr>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Product</strong></th>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Price</strong></th>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Quantity</strong></th>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Total</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ \App\Helpers\Currency::format($product->discounted_price) }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ \App\Helpers\Currency::format($product->discounted_price * $product->quantity) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                            <td>{{ \App\Helpers\Currency::format($order->total) }}</td>
                        </tr>
                        @if(!is_null($order->discount_code))
                        <tr>
                            <td colspan="3" class="text-right"><strong>Discount (<small>{{ $order->discount }}</small>)</strong></td>
                            <td>{{ \App\Helpers\Currency::format($order->total) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="text-right"><strong>Tax</strong></td>
                            <td>{{ \App\Helpers\Currency::format($order->tax) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Shipping</strong></td>
                            <td>{{ \App\Helpers\Currency::format($order->shipping) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Amount</strong></td>
                            <td>{{ \App\Helpers\Currency::format($order->total) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h2 class="h5 text-uppercase">Transactions</h2>
                <div class="table-responsive mb-4">
                    <table class="table">
                        <thead class="bg-light">
                        <tr>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Transaction</strong></th>
                            <th class="border-0" scope="col"><strong class="text-small text-uppercase">Date</strong></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->status($transaction->transaction) }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if ($loop->last && $transaction->transaction == \App\Models\OrderTransaction::FINISHED &&
                                    \Carbon\Carbon::now()->addDays(5)->diffInDays($transaction->created_at->format('Y-m-d')) != 0)
                                        <button type="button" onclick="requestReturnOrder('{{ $order->id }}')" class="btn btn-link text-right">
                                            you can return order in {{ 5 - $transaction->created_at->diffInDays() }} days
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
