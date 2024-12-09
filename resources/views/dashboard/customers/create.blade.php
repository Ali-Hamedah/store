@extends('dashboard.layouts.master')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Create Customer</h6>
            <div class="ml-auto">
                <a href="{{ route('dashboard.customers.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Customers</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('dashboard.customers.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="" class="form-control">
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                   
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="mobile">Phone Number</label>
                            <input type="text" name="phone_number" value="" class="form-control">
                            @error('phone_number')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <div>
                                <x-input-label for="birthday" :value="__('Birthday')" />
                                <x-form.date :value="old('Birthday')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <div>
                                <x-input-label for="country" :value="__('country')" />
                                <x-form.select name="country" :options="$countries"  />
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="street_address">Street Address</label>
                            <input type="text" name="street_address" value="" class="form-control">
                            @error('street_address')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
        
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select type="text" name="gender" value="" class="form-control">
                           <option value="male">Male</option>
                           <option value="female">Female</option>
                            </select>
                            @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" value="" class="form-control">
                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Iamge</label>
                        <input type="file" name="image" id="image" class="file-input-overview">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Add Customer</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function(){
           $("#customer-image").fileinput({
               theme: "fas",
               maxFileCount: 1,
               allowedFileTypes: ['image'],
               showCancel: true,
               showRemove: false,
               showUpload: false,
               overwriteInitial: false
           });
        });
    </script>
@endsection
