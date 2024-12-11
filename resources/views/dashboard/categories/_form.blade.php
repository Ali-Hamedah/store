  @push('css')
      
  @endpush
  <div class="form-group">
            <label for="exampleFormControlInput1">Name English</label>
            <input value="{{ $category->name }}" type="text" name="name_en" class="form-control">
            @error('name_en')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Name Arabic</label>
            <input value="{{ $category->name }}" type="text" name="name_ar" class="form-control">
            @error('name_ar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>parents </label>
            <select name="parent_id" class="form-control">
                <option value="">{{__('categories.main_category')}}</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}"
                        {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">description English</label>
            <textarea name="description_en" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description_en')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">description Arabic</label>
            <textarea name="description_ar" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description_ar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Iamge</label>
            <input type="file" name="image" id="category-image" class="file-input-overview">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <fieldset class="form-group row">
            <legend class="col-form-label col-sm-2 float-sm-left pt-0">Status</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="gridRadios1" value="Active"
                        {{ old('status', $category->status) == 'active' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gridRadios1">
                        Active
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="gridRadios2" value="Archived"
                        {{ old('status', $category->status) == 'archived' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gridRadios2">
                        Archived
                    </label>
                </div>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </fieldset>
        <div class="form-group">
            <button type="submit" class="but btn-primary">Save</button>
        </div>

        @push('scripts')
               {{-- images --}}
<script>
    $("#category-image").fileinput({
                theme: "fas",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if($category->image != '')
                    "{{ asset('assets/categories/' . $category->image) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                
            });
    </script>
        @endpush