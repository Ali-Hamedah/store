@extends('dashboard.layouts.master')
@section('title')
    categories
@endsection

@section('page-header')
@endsection
@section('content')

<div class="container p-3"> <!-- يضيف مسافة داخلية حول النموذج -->
    <form action="{{ route('dashboard.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Name</label>
            <input  type="text" name="name" class="form-control" >
        </div>
        <div class="form-group">
            <label >parents </label>
           
            <select name="parent_id" class="form-control" >
        <option value="">categories parent</option>
        @foreach($parents as $parent)
            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
        @endforeach
    </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">description</label>
            <textarea name="description" class="form-control"  rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Iamge</label>
            <input type="file" name="image" class="from-control">
        </div>

        <fieldset class="form-group row">
            <legend class="col-form-label col-sm-2 float-sm-left pt-0">Status</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="gridRadios1" value="Active">
                <label class="form-check-label" for="gridRadios1">
                  Active
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="gridRadios2" value="Archived">
                <label class="form-check-label" for="gridRadios2">
                    Archived
                </label>
              </div>
            
            </div>
          </fieldset>

        <div class="form-group">
            <button type="submit" class="but btn-primary">Save</button>
        </div>
    </form>
</div>


@endsection
