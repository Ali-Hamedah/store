@extends('dashboard.layouts.master')
@section('title')
   Edit Category
@endsection

@section('content')

@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Home</a></li>
    <li class="breadcrumb-item active">categories</li>
@endsection

<div class="container p-3 card shadow mb-4" style="width: 99%; margin: auto;"> 
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
      @include('dashboard.categories._form')
    </form>
</div>


@endsection
