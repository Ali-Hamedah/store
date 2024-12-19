<x-front-layout title="Cart">

    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ auth()->user()->full_name }} Profile</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.profile') }}">Profile</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- PROFILE SECTION -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- General Information -->
                <div class="col-lg-8">
                    <h2 class="h5 text-uppercase mb-4 border-bottom pb-2">General Information</h2>
                    <div class="card p-4 shadow-sm">
                        <p class="mb-0">Here you can update your personal profile details.</p>
                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Full Name:</strong></span>
                                <span>{{ auth()->user()->full_name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Email:</strong></span>
                                <span>{{ auth()->user()->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>Mobile:</strong></span>
                                <span>{{ auth()->user()->mobile }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    @include('front.layouts.customer.sidebar')
                </div>
            </div>
        </div>
    </section>

</x-front-layout>
