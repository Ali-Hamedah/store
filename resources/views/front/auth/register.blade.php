<x-front-layout title="Login">

    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>No Account? Register</h3>
                                <p>Registration takes less than a minute but gives you full control over your orders.
                                </p>
                            </div>
                            <div class="social-login">
                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-12"><a class="btn google-btn"
                                            href="{{ route('auth.google') }}"><i class="lni lni-google"></i> Google
                                            login</a>
                                    </div>
                                </div>
                            </div>
                            <div class="alt-option">
                                <span>Or</span>
                            </div>
                            @if ($errors->has(config('fortify.username')))
                                <div class="alert alert-danger">
                                    {{ $errors->first(config('fortify.username')) }}
                                </div>
                            @endif

                            <div class="form-group input-group">
                                <label for="reg-fn">Name</label>
                                <input class="form-control" type="text" name="name" id="reg-email" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">Email</label>
                                <input class="form-control" type="text" name="email" id="reg-email" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">phone_number</label>
                                <input class="form-control" type="text" name="phone_number" id="reg-email" required>
                                @error('phone_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-pass">Password</label>
                                <input class="form-control" type="password" name="password" id="reg-pass" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group input-group mt-4">
                                <label for="password_confirmation">Confirm Password</label>
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex flex-wrap justify-content-between bottom-content">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" value="1"
                                        class="form-check-input width-auto" id="exampleCheck1">
                                    <label class="form-check-label">Remember me</label>
                                </div>

                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Register</button>
                            </div>
                            @if (Route::has('register'))
                                <p class="outer-link">Already have an account? <a
                                        href="{{ route('choose.login') }}">Login Now</a>
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->

</x-front-layout>
