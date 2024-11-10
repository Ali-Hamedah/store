@extends('dashboard.layouts.master')
@section('title')
    categories
@endsection

@section('content')
@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index')}}">Home</a></li>
    <li class="breadcrumb-item active">categories</li>
@endsection
<div class="card shadow mb-4" style="width: 99%; margin: auto;">
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
                <th>created_at</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent_id }}</td>
                    <td>{{ $category->created_at }}</td>
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
</div>
@endsection
