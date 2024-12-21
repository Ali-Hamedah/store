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
        @can('create order')
        <div class="ml-auto">
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">{{ __('categories.add_new_product') }}</span>
            </a>
        </div>
        @endcan
    </div>
    <table id="example" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('orders.order_number') }}</th>
                <th>{{ __('orders.store') }}</th>
                <th>{{ __('orders.payment_method') }}</th>
                <th>{{ __('orders.status') }}</th>
                {{-- <th>{{ __('orders.payment_status') }}</th> --}}
                <th>{{ __('orders.shipping') }}</th>
                <th>{{ __('orders.tax') }}</th>
                <th>{{ __('orders.discount') }}</th>
                <th>{{ __('orders.total') }}</th>
                <th class="text-center" style="width: 30px;">Actions</th>
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
                    
                        <td>{!! $order->statusWithLabel() !!}</td>
                   
                    <td>{{ number_format($order->shipping, 2) }}</td>
                    <td>{{ number_format($order->tax, 2) }}</td>
                    <td>{{ number_format($order->discount, 2) }}</td>
                    <td>{{ number_format($order->total, 2) }}</td>
<td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('dashboard.orders.show', $order->id) }}" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="javascript:void(0);" onclick="if (confirm('Are you sure to delete this record?')) { document.getElementById('delete-orders-{{ $order->id }}').submit(); } else { return false; }" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
</td>
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
