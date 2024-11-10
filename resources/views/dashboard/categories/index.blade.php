@extends('dashboard.layouts.master')
@section('title')
    categories
@endsection

@section('page-header')
@endsection
@section('content')
@if(session()->has('success'))
    
<div class="alert alert-success" role="alert">
    Category created successfully
  </div>
@endif

<div  style="width: 95%; margin: auto;">
<div class="mb-5">
    <a href="{{ route('dashboard.categories.create') }}"  class="btn btn-outline-primary">Add</a>
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
    </table>
</div>
@endsection
