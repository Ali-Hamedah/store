@extends('dashboard.layouts.master')
@section('title')
    categories
@endsection

@section('content')
@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
@endsection

<div class="card shadow mb-4" style="width: 99%; margin: auto;">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Products</h6>
        <div class="ml-auto">
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">{{ __('categories.add_new_product') }}</span>
            </a>
        </div>
    </div>
    <table id="example" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('orders.order_number') }}</th>
                <th>{{ __('orders.store') }}</th>
                <th>{{ __('orders.payment_method') }}</th>
                <th>{{ __('orders.status') }}</th>
                <th>{{ __('orders.payment_status') }}</th>
                <th>{{ __('orders.shipping') }}</th>
                <th>{{ __('orders.tax') }}</th>
                <th>{{ __('orders.discount') }}</th>
                <th>{{ __('orders.total') }}</th>
                {{-- <th><button id="btn_delete_all" class="btn btn-danger">
                        <span class="icon text-white-50">
                            <i class="fa fa-trash icon text-white-50"></i>
                        </span>
                    </button><input type="checkbox" id="select-all"></th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->number }}</td>
                    <td>{{ $order->store->name }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>
                        <span
                            class="badge 
                        {{ $order->status == 'completed' ? 'badge-success' : ($order->status == 'pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $order->status == 'completed' ? 'completed' : ($order->status == 'pending' ? 'pending' : 'cancelled') }}
                        </span>
                    <td>
                        <span
                            class="badge 
                        {{ $order->payment_status == 'paid' ? 'badge-success' : ($order->payment_status == 'pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $order->payment_status == 'paid' ? 'paid' : ($order->payment_status == 'pending' ? 'pending' : 'cancelled') }}
                        </span>
                    </td>
                    <td>{{ number_format($order->shipping, 2) }}</td>
                    <td>{{ number_format($order->tax, 2) }}</td>
                    <td>{{ number_format($order->discount, 2) }}</td>
                    <td>{{ number_format($order->total, 2) }}</td>

                    {{-- <td>
                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                            href="{{ route('dashboard.products.edit', $order->id) }}">
                            <i class="las la-pen"></i>
                        </a>
                        <!-- Button to open the module-->
                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal"
                            data-target="#delete{{ $order->id }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                    <td><input type="checkbox" name="delete_select" value="{{ $order->id }}" class="delete_select">
                    </td> --}}
                </tr>
                <!-- Modal Delete -->
                {{-- @include('dashboard.products.delete')
                @include('dashboard.products.delete_select') --}}
            @empty
                <tr>
                    <td>No date</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9">
                    <div class="d-flex align-items-center">
                        {!! $orders->appends(request()->all())->links() !!}
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
@section('js')
{{-- <script>
    document.getElementById('select-all').onclick = function() {
        let checkboxes = document.querySelectorAll('input[name="delete_select"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };
</script>

<script>
    $(document).ready(function() {
        $("#btn_delete_all").click(function() {
            var selected = [];
            $("#example input[name=delete_select]:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#deleteModal').modal('show')
                $('input[id="delete_select_id"]').val(selected);
            }
        });
    });
</script> --}}
@endsection
