@push('styles')
    <link href="{{ asset('css/tagify.css') }}" rel="stylesheet" type="text/css" />
  
@endpush

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

<livewire:counter /> 

<div class="form-group">
    <label for="exampleFormControlTextarea1">Iamge</label>
    <input type="file" lass="from-control" name="images[]" multiple>
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

{{-- <div class="form-group">
    <x-form.select label="Size" name="size_id" :options="$sizes" :selected="$parentCategory->id ?? ''" />
</div> --}}



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

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            $('[name=category_id]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ route('dashboard.section.get', ':id') }}".replace(':id',
                            SectionId),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="sub_category"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="sub_category"]').append(
                                    '<option value="' + key + '">' + value + 
                                    '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>

<script>
    import 'livewire-vite';

</script>
@endpush

