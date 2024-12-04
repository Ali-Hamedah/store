@extends('dashboard.layouts.master')
@section('title')
    categories
@endsection

@section('content')
@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Home</a></li>
    <li class="breadcrumb-item active">categories</li>
@endsection

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">categories</h6>
        <div class="ml-auto">
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">{{ __('categories.add_new_category') }}</span>
            </a>
        </div>
    </div>
    <table id="example" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('categories.name') }}</th>
                <th>{{ __('categories.parent') }}</th>
                <th>{{ __('categories.description') }}</th>
                <th>{{ __('categories.products') }}</th>
                <th>{{ __('categories.status') }}</th>
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
            @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="{{ route('dashboard.categories.show', $category->id) }}" >{{ $category->name }} </td>
                    <td>{{ $category->parent_id }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->products->count() }}</td>
                    <td>
                        <span class="badge {{ $category->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ $category->status == 'active' ? 'Active' : 'Archived' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ $category->image ? asset('assets/categories/' . $category->image) : '#' }}">
                            <img src="{{ $category->image ? asset('assets/categories/' . $category->image) : asset('assets/categories/no_image.jpg') }}"
                                style="width: 50px; height: 50px;">
                        </a>
                    </td>
                    <td>
                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                            href="{{ route('dashboard.categories.edit', $category->id) }}">
                            <i class="las la-pen"></i>
                        </a>
                        <!-- Button to open the module-->
                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal"
                            data-target="#delete{{ $category->id }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                    <td><input type="checkbox" name="delete_select" value="{{ $category->id }}" class="delete_select">
                    </td>
                </tr>
                <!-- Modal Delete -->
                @include('dashboard.categories.delete')
                @include('dashboard.categories.delete_select')
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
                        {!! $categories->appends(request()->all())->links() !!}
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
