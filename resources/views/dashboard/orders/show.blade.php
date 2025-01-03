@extends('dashboard.layouts.master')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Order ({{ $order->ref_id }})</h6>
            <div class="ml-auto">
                <form action="{{ route('dashboard.orders.update', $order->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-row align-items-center">
                        <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Order status</div>
                            </div>
                            <select class="form-control" name="order_status" style="outline-style: none;" onchange="this.form.submit()">
                                <option value=""> Choose your action </option>
                                @foreach($order_status_array as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex">
            <div class="col-8">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Ref. Id</th>
                            <td>{{ $order->ref_id }}</td>
                            <th>Customer</th>
                            <td><a href="{{ route('dashboard.customers.show', $order->user_id) }}">{{ $order->user->name }}</a></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><a href="#">{{ $order->addresses->pluck('city')->first() }}</a></td>
                            <th>Shipping Company</th>
                            <td><a href="#">DHL</a></td>
                            {{-- <td>{{ $order->shipping_company->name . '('. $order->shipping_company->code .')' }}</td> --}}
                        </tr>
                        <tr>
                            <th>Created date</th>
                            <td>{{ $order->created_at->format('d-m-Y h:i a') }}</td>
                            <th>Order status</th>
                            <td>{!! $order->statusWithLabel() !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>{{ \App\Helpers\Currency::format($order->total_before_discount) }}</td>
                        </tr>
                        <tr>
                            <th>Discount code</th>
                            <td>{{ $order->discount_code }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>{{ \App\Helpers\Currency::format($order->discount) }}</td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td>{{ \App\Helpers\Currency::format($order->shipping) }}</td>
                        </tr>
                        <tr>
                            <th>tax</th>
                            <td>{{ \App\Helpers\Currency::format($order->tax) }}</td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>{{ \App\Helpers\Currency::format($order->total) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Transaction</th>
                    <th>Transaction number</th>
                    <th>Payment result</th>
                    <th>Action date</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->status($transaction->transaction) }}</td>
                        <td>{{ $transaction->transaction_number }}</td>
                        <td>{{ $transaction->payment_result }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d h:i a') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No transactions found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Details</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->products as $product)
                    <tr>
                        <td><a href="{{ route('dashboard.products.show', $product->id) }}">{{ $product->name }}</a></td>
                        <td>{{ $product->order_item->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No products found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
