@extends('dashboard.layouts.master')
@section('title')
   Trash categories
@endsection
@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Home</a></li>
    <li class="breadcrumb-item active">categories</li>
@endsection
@section('content')
<form action="{{ route('dashboard.categories.restore', 'test') }}" method="POST" style="display:inline;">
    @csrf

<div class="card shadow mb-4" style="width: 99%; margin: auto;">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Products</h6>
        <div class="ml-auto">
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
                <th>
                    
                    
                    <button type="submit" class="btn btn-warning">Restore
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
                        {{-- <form id="restoreAll" action="{{ route('dashboard.categories.restoreAll', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning">Restore</button>
                        </form> --}}

                        <button type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#restoreModal-{{ $category->id }}">
                            <i class="las la-trash"></i>
                        </button>
                        {{-- <!-- Button to open the module-->
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                            data-target="#deleteModal-{{ $category->id }}">
                            <i class="las la-trash"></i>
                        </button> --}}

                        
                        <td><input type="checkbox" name="selected_items[]" value="{{ $category->id }}"></td>
                        <!-- Delete model inside a module -->
                      
                    </td>
                </tr>
                {{-- @include('dashboard.categories.delete', ['route' => route('dashboard.categories.forceDelete', $category->id)] )
                @include('dashboard.categories.restore') --}}
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
</form>
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

<script>
    document.querySelectorAll('restoreAll').forEach(form => {
        form.addEventListener('submit', function(event) {
            // منع إرسال أي نموذج آخر في الصفحة
            document.querySelectorAll('restoreAll').forEach(f => {
                if (f !== this) {
                    f.querySelectorAll('button[type="submit"]').forEach(button => {
                        button.disabled = true;
                    });
                }
            });
        });
    });
</script>
@endsection
