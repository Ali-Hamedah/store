@extends('dashboard.layouts.master')
@section('title')
    categories
@endsection

@section('content')
@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Home</a></li>
    <li class="breadcrumb-item active">categories</li>
@endsection

<div class="card shadow mb-4" style="width: 99%; margin: auto;">
    <form method="POST" action="{{ route('dashboard.items.delete') }}">
        @csrf
        @method('DELETE')
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Products</h6>
        <div class="ml-auto">
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">Add new Category</span>
            </a>
           
            
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>name</th>
                <th>parent</th>
                <th>description</th>
                <th>status</th>
                <th>Image</th>
                <th>Processes</th>
                <th><button type="submit" class="btn btn-danger">
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
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent_id }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <span class="badge {{ $category->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ $category->status == 'active' ? 'Active' : 'Archived' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ $category->image ? asset('images/' . $category->image) : '#' }}">
                            <img src="{{ $category->image ? asset('images/' . $category->image) : asset('images/no_image.jpg') }}"
                                style="width: 50px; height: 50px;">
                        </a>
                    </td>
                    <td>
                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                            href="{{ route('dashboard.categories.edit', $category->id) }}">
                            <i class="las la-pen"></i>
                        </a>
                        <!-- Button to open the module-->
                        
                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" data-target="#deleteModal-{{ $category->id }}">
                            <i class="las la-trash"></i>
                        </a>
                        
                      <!-- Modal Delete -->
                      @include('dashboard.categories.delete', ['route' => route('dashboard.categories.destroy', $category->id)])

                    </td>
                    <td><input type="checkbox" name="selected_items[]" value="{{ $category->id }}"></td>

                </tr>
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
   
</form>
</div>
@endsection
@section('js')
<script>
    document.getElementById('select-all').onclick = function() {
        let checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };
</script>
@endsection
