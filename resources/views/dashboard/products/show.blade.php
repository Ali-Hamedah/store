@extends('dashboard.layouts.master')

@section('title', 'View Product')

@section('Starter_Page')
<li class="breadcrumb-item"><a href="{{ route('dashboard.dashboard') }}">{{__('main.home')}}</a></li>
<li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">{{__('main.products')}}</a></li>
<li class="breadcrumb-item active">View Product</li>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="m-0 text-primary"><i class="fa fa-box-open"></i> Product Details</h4>
            <a href="{{ route('dashboard.products.index') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-arrow-left"></i> Back to Products
            </a>
        </div>
        <div class="card-body">
            <!-- Product Basic Information -->
            <h5 class="text-secondary mb-3"><i class="fa fa-info-circle"></i> Basic Information</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Product Name (English):</strong></label>
                        <p class="text-muted">{{ $product->getTranslation('name', 'en') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Product Name (Arabic):</strong></label>
                        <p class="text-muted">{{ $product->getTranslation('name', 'ar') }}</p>
                    </div>
                </div>
            </div>

            <!-- Category Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Category:</strong></label>
                        <p class="text-muted">{{ $parentCategory->name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Sub Category:</strong></label>
                        <p class="text-muted">{{ $product->category->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <h5 class="text-secondary mb-3"><i class="fa fa-dollar-sign"></i> Pricing</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Price:</strong></label>
                        <p class="text-muted">{{ $product->price }} {{ __('main.currency') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Compare Price:</strong></label>
                        <p class="text-muted">{{ $product->compare_price ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Tags & Images -->
            <div class="mb-4">
                <div class="form-group">
                    <label><strong>Tags:</strong></label>
                    <p class="text-muted">{{ $tags }}</p>
                </div>
                <div class="form-group">
                    <label><strong>Images:</strong></label>
                    <div class="d-flex gap-3 flex-wrap">
                        @if($product->media()->count() > 0)
                            @foreach($product->media as $media)
                                <img src="{{ asset('assets/products/' . $media->file_name) }}" class="img-thumbnail shadow-sm" style="width: 120px; height: auto;">
                            @endforeach
                        @else
                            <p class="text-muted">No images available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <h5 class="text-secondary mb-3"><i class="fa fa-clipboard"></i> Additional Information</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><strong>Status:</strong></label>
                        <p class="text-muted">{{ ucfirst($product->status) }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><strong>Favorite:</strong></label>
                        <p class="text-muted">{{ $product->is_featured ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><strong>New:</strong></label>
                        <p class="text-muted">{{ $product->is_new ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>

            <!-- Variants -->
            <div class="form-group">
                <h5 class="text-secondary"><i class="fa fa-boxes"></i> Variants</h5>
                @if($product->variants->count() > 0)
                    @foreach ($product->variants as $variant)
                        <div class="variant-row border rounded p-2 mb-3 shadow-sm bg-light">
                            <p><strong>Size:</strong> {{ $variant->size->name }}</p>
                            <p><strong>Color:</strong> {{ $variant->color->name }}</p>
                            <p><strong>Quantity:</strong> {{ $variant->quantity }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No variants available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
