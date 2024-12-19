<x-front-layout title="Addresses">

    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ auth()->user()->name }} Addresses</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.addresses') }}">Addresses</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

 
    
    

    <!-- Form for adding a new address -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4 class="mb-4">Edit Address</h4>
                    <!-- تغيير method إلى PUT أو PATCH لتحديث العنوان -->
                    <form action="{{ route('customer.address.update', $address->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- أو @method('PATCH') إذا كنت تفضل ذلك -->
                        <div class="checkout-steps-form-style-1">
                            <ul id="accordionExample">
                                <li>
                                    <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="true" aria-controls="collapseThree">Address Details</h6>
                                    <section class="checkout-steps-form-content collapse show" id="collapseThree"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>User Name</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="first_name" 
                                                                value="{{ old('first_name', $address->first_name) }}" 
                                                                placeholder="First Name" />
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="last_name" 
                                                                value="{{ old('last_name', $address->last_name) }}" 
                                                                placeholder="Last Name" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Email Address</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="email" 
                                                            value="{{ old('email', $address->email) }}" 
                                                            placeholder="Email Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Phone Number</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="phone_number" 
                                                            value="{{ old('phone_number', $address->phone_number) }}" 
                                                            placeholder="Phone Number" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Mailing Address</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="street_address" 
                                                            value="{{ old('street_address', $address->street_address) }}" 
                                                            placeholder="Mailing Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>City</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="city" 
                                                            value="{{ old('city', $address->city) }}" 
                                                            placeholder="City" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Post Code</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="postal_code" 
                                                            value="{{ old('postal_code', $address->postal_code) }}" 
                                                            placeholder="Post Code" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Region/State</label>
                                                    <div class="select-items">
                                                        <x-form.input name="state" 
                                                            value="{{ old('state', $address->state) }}" 
                                                            placeholder="State" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Country</label>
                                                    <div class="form-input form">
                                                        <x-form.select name="country" 
                                                            :options="$countries" 
                                                            value="{{ old('country', $address->country) }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-checkbox checkbox-style-3">
                                                    <input type="checkbox" id="checkbox-default" name="default" 
                                                        value="1" {{ $address->default ? 'checked' : '' }}>
                                                    <label for="checkbox-default"><span></span></label>
                                                    <p>Set this address as default.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                            </ul>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Address</button>
                    </form>
                </div>
    
                <!-- SIDEBAR -->
                <div class="col-lg-4">
                    @include('front.layouts.customer.sidebar')
                </div>
            </div>
        </div>
    </section>
    
</x-front-layout>
