@push('css')
    <link href="{{ asset('css/tagify.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/summernote/summernote-bs4.min.css') }}">
@endpush
<div class="row">
    <div class="col-6">
<div class="form-group">
    <x-form.input label="Product Name English" class="form-control-lg" role="input" name="name_en" :value="$product->name" />
        @error('name_en')
        <div class="text-danger">{{ $message }}</div>
    @enderror
 </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <x-form.input label="Product Name Arabic" class="form-control-lg" role="input" name="name_ar" :value="$product->name" />
                @error('name_ar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
         </div>
            </div>
</div>        

<div class="form-group-wrapper" style="display: flex; gap: 15px; align-items: center;">
    <div class="form-group" style="flex: 1;">
        <x-form.select label="Category" name="category_id" :options="$categories" :selected="$parentCategory->id ?? ''" />
    </div>

    <div style="flex: 1;">
        <label for="">Sub Category</label>
        <select id="sub_category" name="sub_category" style="width: 100%; border-radius: 5px; padding: 5pt">
            @foreach ($subCategories as $subCategory)
                <option value="{{ $subCategory->id }}" {{ $product->category_id == $subCategory->id ? 'selected' : '' }}>
                    {{ $subCategory->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-6">
<div class="form-group">
    <x-form.textarea label="Description Name English" class="form-control summernote" role="input" name="description_en" :value="$product->description" />
        @error('description_en')
        <div class="text-danger">{{ $message }}</div>
    @enderror
 </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <x-form.textarea label="Description Name Arabic" class="form-control summernote" role="input" name="description_ar" :value="$product->description" />
                @error('description_ar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
         </div>
            </div>
</div>  

<div style="display: flex; gap: 15px; align-items: center;">
    <div class="form-group" style="flex: 1;">
        <x-form.input label="Price" class="form-control-lg" role="input" name="price" :value="$product->price" />
    </div>

    <div class="form-group" style="flex: 1;">
        <x-form.input label="Compare Price" name="compare_price" :value="$product->compare_price" />
    </div>
</div>


<div class="form-group">
    <x-form.input label="Tags" name="tags" :value="$tags" />
    <x-form.validation-feedback :name="$tags" />
</div>

<div class="form-group">
    <label for="exampleFormControlTextarea1">Image</label>
    <input type="file" name="images[]" id="product-images" class="file-input-overview" multiple="multiple">
    @error('image')
        <div class="text-danger">{{ $message }}</div>    
    @enderror
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; align-items: start;">
    <div class="form-group">
        <label for="">Status</label>
        <div>
            <x-form.radio name="status" :checked="$product->status" :options="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']" />
        </div>
    </div>

    <div class="form-group">
        <label for="">Favorite</label>
        <div>
            <x-form.radio name="is_featured" :checked="$product->is_featured" :options="[ 1 => 'Yes', 0 => 'No']" />
        </div>
    </div>

    <div class="form-group">
        <label for="">New</label>
        <div>
            <x-form.radio name="is_new" :checked="$product->is_new" :options="[1 => 'Yes', 0 => 'No']" />
        </div>
    </div>

    <div class="form-group">
        <label for="">Offer</label>
        <div>
            <x-form.radio name="is_offer" :checked="$product->is_offer" :options="[1 => 'Yes', 0 => 'No']" />
        </div>
    </div>
</div>


<input type="hidden" name="variants" value="{{ json_encode($variants ?? []) }}">

<div id="productVariants">
    <div id="variantContainer">
        <!-- سيتم تكرار هذه البلوك عند إضافة سطر جديد -->
        <div class="variant-row mb-3 p-2 border rounded">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <select class="form-select product-size" name="sizes[]" style="height: 45px;">
                        <option>Size</option>
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select product-color" name="colors[]" style="height: 45px;">
                        <option>Color</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control product-quantity" name="quantities[]" placeholder="العدد" min="0" style="height: 45px;">
                </div>
                <div class="col-md-3 text-center">
                    <button type="button" class="btn btn-danger remove-variant w-100" style="height: 45px;">حذف</button>
                </div>
            </div>
        </div>
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
    
    {{-- images --}}
<script>
    $("#product-images").fileinput({
                theme: "fas",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            });
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
        // إضافة سطر جديد عند الضغط على زر "إضافة"
$('#addVariant').click(function() {
    var variantHtml = `
        <div class="variant-row mb-2">
            <div class="row">
                <div class="col-md-3">
                    <select class="form-select product-size" name="sizes[]">
                          <option>Size</option>
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select product-color" name="colors[]">
                          <option>Color</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control product-quantity" name="quantities[]" placeholder="العدد" min="1">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger remove-variant">حذف</button>
                </div>
            </div>
        </div>
    `;
    $('#variantContainer').append(variantHtml);
});

// حذف السطر عند الضغط على زر "حذف"
$(document).on('click', '.remove-variant', function() {
    $(this).closest('.variant-row').remove();
});


    </script>


   <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
   <script>
    CKEDITOR.replace('description_en', {
    toolbar: [
        { name: 'basicstyles', items: ['Bold', 'Italic'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList'] }
    ],
    height: 300,
    language: 'en'
});

CKEDITOR.replace('description_ar', {
    toolbar: [
        { name: 'basicstyles', items: ['Bold', 'Italic'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList'] }
    ],
    height: 300,
    language: 'ar'
});

</script>


@endpush
