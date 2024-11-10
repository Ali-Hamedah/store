@extends('dashboard.layouts.master')
@section('title')
    categories
@endsection

@section('content')

@section('Starter_Page')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Home</a></li>
    <li class="breadcrumb-item active">categories</li>
@endsection

<div class="container p-3 card shadow mb-4" style="width: 99%; margin: auto;"> <!-- يضيف مسافة داخلية حول النموذج -->
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="exampleFormControlInput1">Name</label>
            <input value="{{ $category->name }}" type="text" name="name" class="form-control">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label>parents </label>
            <select name="parent_id" class="form-control">
                <option value="">categories parent</option>
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
            <label for="exampleFormControlTextarea1">description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Iamge</label>
            <input type="file" name="image" class="from-control">
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
    </form>
</div>


@endsection
