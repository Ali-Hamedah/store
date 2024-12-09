@extends('dashboard.layouts.master')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Customer ({{ $customer->full_name }})</h6>
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

            <form action="{{ route('dashboard.customers.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="name">First Name</label>
                            <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control">
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                   
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ old('email', $customer->email) }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $customer->phone_number) }}" class="form-control">
                            @error('phone_number')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <div>
                                <x-input-label for="birthday" :value="__('Birthday')" />
                                <x-form.date :value="old('Birthday', $customer->birthday)" />
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <div>
                                <x-input-label for="country" :value="__('country')" />
                                <x-form.select name="country" :options="$countries" :selected="old('country', $customer->country)" />
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="street_address">Street Address</label>
                            <input type="text" name="street_address" value="{{ old('street_address', $customer->street_address) }}" class="form-control">
                            @error('street_address')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
        
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select type="text" name="gender" value="{{old('gender', $customer->gender == 'male' ? 'female' : '' )}}" class="form-control">
                           <option value="male">Male</option>
                           <option value="female">Female</option>
                            </select>
                            @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control">
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
                    <button type="submit" name="submit" class="btn btn-primary">Update Customer</button>
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
                overwriteInitial: false,
                initialPreview: [
                    @if($customer->user_image != '')
                    "{{ asset('assets/users/' . $customer->user_image) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($customer->user_image != '')
                    {
                        caption: "{{ $customer->user_image }}",
                        size: '1111',
                        width: "120px",
                        url: "{{ route('admin.customers.remove_image', ['customer_id' => $customer->id, '_token' => csrf_token()]) }}",
                        key: {{ $customer->id }}
                    }
                    @endif
                ]
            });
        });
    </script>
@endsection
