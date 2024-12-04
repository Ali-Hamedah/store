@extends('dashboard.layouts.master')
@section('title')
   Edit product
@endsection
@push('css')
<link href="{{ asset('css/tagify.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('Starter_Page')
<li class="breadcrumb-item"><a href="{{ route('dashboard.dashboard') }}">{{__('main.home')}}</a></li>
<li class="breadcrumb-item active"><a href="{{ route('dashboard.products.index') }}">{{__('main.products')}}</a></li>
@endsection

@section('content')


<div class="container p-3 card shadow mb-4" style="width: 99%; margin: auto;"> 
    <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
       
    
    <div class="form-group">
        <x-form.input label="Product Name" class="form-control-lg" role="input" name="name" :value="$product->name" />
    </div>
    
    <div class="form-group">
        <x-form.select label="Category" name="category_id" :options="$categories" :selected="$parentCategory->id ?? ''" />
    </div>
    
    <div>
        <select id="sub_category" name="sub_category" style="width: 100%; border-radius: 5px; padding: 5pt">
            @foreach ($subCategories as $subCategory)
                <option value="{{ $subCategory->id }}" {{ $product->category_id == $subCategory->id ? 'selected' : '' }}>
                    {{ $subCategory->name }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label for="">Description</label>
        <x-form.textarea name="description" :value="$product->description" />
    </div>
    
    <div class="form-group">
        <x-form.input label="Price" class="form-control-lg" role="input" name="price" :value="$product->price" />
    </div>
    
    <div class="form-group">
        <x-form.input label="Compare Price" name="compare_price" :value="$product->compare_price" />
    </div>
    
    <div class="form-group">
        <x-form.input label="Tags" name="tags" :value="$tags" />
        <x-form.validation-feedback :name="$tags" />
    </div>
    
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Image</label>
        <input type="file" class="from-control" name="images[]" multiple>
        @error('image')
            <div class="text-danger">{{ $message }}</div>    
        @enderror
    </div>
    
    <div class="form-group">
        <label for="">Status</label>
        <div>
            <x-form.radio name="status" :checked="$product->status" :options="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']" />
        </div>
    </div>
    
    <input type="hidden" name="variants" value="{{ json_encode($variants ?? []) }}">
    
    <div id="productVariants">
        <div id="variantContainer">
            <!-- سيتم تكرار هذه البلوك عند إضافة سطر جديد -->
            @foreach ($product->variants as $variant)
           
            <div class="variant-row mb-2">
                <div class="row">
                    <input type="hidden" name="variant[]" value="{{$variant->id}}" />
                    <div class="col-md-3">
                        <select class="form-select product-size" name="sizes[]" disabled>
                            <option value="{{ $variant->size->id }}" selected>
                                {{ $variant->size->name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select product-color" name="colors[]" disabled>
                            <option value="{{ $variant->color->id }}" selected>
                                {{ $variant->color->name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input 
                            type="number" 
                            class="form-control product-quantity" 
                            name="quantities[]" 
                            value="{{ $variant->quantity }}" 
                            min="1" 
                            placeholder="العدد"
                        >
                    </div>
                    
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="form-group">
    <button type="button" id="addVariant" class="btn btn-secondary">Add options size or color</button>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    </div>
    
    @push('scripts')
        <script src="{{ asset('js/tagify.min.js') }}"></script>
        <script src="{{ asset('js/tagify.polyfills.min.js') }}"></script>
        <script>
            var inputElm = document.querySelector('[name=tags]'),
                tagify = new Tagify(inputElm);
        </script>
    
        <script>
            $(document).ready(function() {
                $('[name=category_id]').on('change', function() {
                    var SectionId = $(this).val();
                    if (SectionId) {
                        $.ajax({
                            url: "{{ route('dashboard.section.get', ':id') }}".replace(':id', SectionId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('select[name="sub_category"]').empty();
                                $.each(data, function(key, value) {
                                    $('select[name="sub_category"]').append('<option value="' + key + '">' + value + '</option>');
                                });
                            },
                        });
                    }
                });
            });
        </script>
    
        <script>
   
  
    // إرسال البيانات عبر AJAX عند الضغط على زر "حفظ"
    $('#saveVariants').click(function() {
        var sizes = [];
        var colors = [];
        var quantities = [];
    
        // جمع البيانات من النماذج
        $('.product-size').each(function() {
            sizes.push($(this).val());
        });
        $('.product-color').each(function() {
            colors.push($(this).val());
        });
        $('.product-quantity').each(function() {
            quantities.push($(this).val());
        });
    
        // إرسال البيانات عبر AJAX
        $.ajax({
            url: '{{ route("dashboard.product.store") }}',  // URL الخاصة بالمسار في Laravel
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sizes: sizes,
                colors: colors,
                quantities: quantities,
            },
            success: function(response) {
                // عملية ناجحة، التعامل مع الاستجابة من السيرفر
                alert("تم حفظ البيانات بنجاح");
            },
            error: function(xhr, status, error) {
                // في حالة حدوث خطأ
                alert("حدث خطأ أثناء الحفظ");
            }
        });
    });
    
        </script>
       
    @endpush
    
    </form>
</div>


@endsection
