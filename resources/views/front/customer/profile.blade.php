<x-front-layout title="Profile">
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Profile</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- PROFILE SECTION-->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Profile Form -->
                <div class="col-lg-8 pt-2">
                    <form action="{{ route('customer.update_profile') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('patch')

                        <!-- Profile Image Section -->
                        <div class="text-center mb-4">
                            <div class="d-inline-block position-relative">
                                <img 
                                    src="{{ auth()->user()->user_image ? asset('assets/users/' . auth()->user()->user_image) : asset('assets/users/avatar.svg') }}" 
                                    alt="{{ auth()->user()->full_name }}" 
                                    class="rounded-circle img-thumbnail" 
                                    width="120">
                                @if (auth()->user()->user_image)
                                    <a href="{{ route('customer.remove_profile_image') }}" class="btn btn-sm btn-outline-danger position-absolute" style="top: 0; right: 0;">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Input Fields -->
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="first_name">First Name</label>
                                <input class="form-control" name="first_name" type="text" value="{{ old('first_name', auth()->user()->first_name) }}" placeholder="Enter your first name">
                                @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="last_name">Last Name</label>
                                <input class="form-control" name="last_name" type="text" value="{{ old('last_name', auth()->user()->last_name) }}" placeholder="Enter your last name">
                                @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="email">Email Address</label>
                                <input class="form-control" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" placeholder="e.g. Jason@example.com">
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="mobile">Mobile Number</label>
                                <input class="form-control" name="mobile" type="tel" value="{{ old('mobile', auth()->user()->mobile) }}" placeholder="e.g. 966512345678">
                                @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase d-flex justify-content-between" for="password">
                                    Password 
                                    <small class="text-danger">(Optional)</small>
                                </label>
                                <input class="form-control" name="password" type="password">
                                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase d-flex justify-content-between" for="password_confirmation">
                                    Confirm Password 
                                    <small class="text-danger">(Optional)</small>
                                </label>
                                <input class="form-control" name="password_confirmation" type="password">
                                @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="text-small text-uppercase" for="user_image">Profile Image</label>
                                <input class="form-control" name="user_image" type="file">
                                @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-12 form-group text-center">
                                <button class="btn btn-dark btn-block" type="submit">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    @include('front.layouts.customer.sidebar')
                </div>
            </div>
        </div>
    </section>
</x-front-layout>
