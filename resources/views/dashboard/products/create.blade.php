@extends('dashboard.layouts.master')
@section('title')
   Create Product
@endsection

@section('content')

@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.dashboard') }}">{{__('main.home')}}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('dashboard.products.index') }}">{{__('main.products')}}</a></li>
@endsection

<div class="container p-3 card shadow mb-4" style="width: 99%; margin: auto;"> 
    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.products._form')
    </form>
</div>


@endsection
