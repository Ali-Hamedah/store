<x-front-layout title="Cart">

    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ auth()->user()->full_name }} {{__('frontend.profile')}}</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('frontend.home')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.profile') }}">{{__('frontend.profile')}}</a></li>
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
                    <h2 class="h5 text-uppercase mb-4 border-bottom pb-2">{{__('frontend.general_information')}}</h2>
                    <div class="card p-4 shadow-sm">
                        <p class="mb-0">{{__('frontend.can_update_your_personal_details')}}.</p>
                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>{{__('frontend.full_name')}}:</strong></span>
                                <span>{{ auth()->user()->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>{{__('frontend.email')}}:</strong></span>
                                <span>{{ auth()->user()->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>{{__('frontend.mobile')}}:</strong></span>
                                <span>{{ auth()->user()->phone_number }}</span>
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
