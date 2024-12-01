@extends('dashboard.layouts.master')
@section('title')
   Create Product
@endsection

@section('content')

@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Product</li>
@endsection

<div class="container p-3 card shadow mb-4" style="width: 99%; margin: auto;"> 
    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.products._form')
    </form>
</div>


@endsection
