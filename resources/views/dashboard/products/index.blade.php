@extends('dashboard.layouts.master')
@section('title')
    {{__('main.products')}}
@endsection

@section('content')
@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">{{__('main.home')}}</a></li>
    <li class="breadcrumb-item active">{{__('main.products')}}</li>
@endsection

<div class="card shadow mb-4" style="width: 99%; margin: auto;">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">{{__('main.products')}}</h6>
        <div class="ml-auto">
            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">{{ __('products.add_new_product') }}</span>
            </a>
        </div>
    </div>
    <table id="example" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('categories.name') }}</th>
                <th>{{ __('products.store') }}</th>
                <th>{{ __('products.category') }}</th>
                <th>{{ __('products.status') }}</th>
                <th>{{ __('categories.Image') }}</th>
                <th>{{ __('categories.Processes') }}</th>
                <th><button id="btn_delete_all" class="btn btn-danger">
                        <span class="icon text-white-50">
                            <i class="fa fa-trash icon text-white-50"></i>
                        </span>
                    </button><input type="checkbox" id="select-all"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        <span class="badge 
                        {{ $product->status == 'active' ? 'badge-success' : ($product->status == 'draft' ? 'badge-warning' : 'badge-danger') }}">
                        {{ $product->status == 'active' ? 'Active' : ($product->status == 'draft' ? 'Draft' : 'Archived') }}
                    </span>
                    
                    </td>
                    <td>
                        <a href="{{ $product->image ? asset('images/' . $product->image) : '#' }}">
                            <img src="{{ $product->image ? asset('images/' . $product->image) : asset('images/no_image.jpg') }}"
                                style="width: 50px; height: 50px;">
                        </a>
                    </td>
                    <td>
                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                            href="{{ route('dashboard.products.edit', $product->id) }}">
                            <i class="las la-pen"></i>
                        </a>
                        <!-- Button to open the module-->
                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal"
                            data-target="#delete{{ $product->id }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                    <td><input type="checkbox" name="delete_select" value="{{ $product->id }}" class="delete_select">
                    </td>
                </tr>
                <!-- Modal Delete -->
                @include('dashboard.products.delete')
                @include('dashboard.products.delete_select')
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
                        {!! $products->appends(request()->all())->links() !!}
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
@section('js')
<script>
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
</script>
@endsection
