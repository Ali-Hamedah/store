<x-front-layout title="orders">
@section('content')

    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ auth()->user()->name }} Orders</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('frontend.home')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.orders') }}">{{__('frontend.orders')}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">

        <div class="row">
            <div class="col-lg-8">
                <livewire:front.customer.order-component />
            </div>


            <!-- SIDEBAR -->
            <div class="col-lg-4">
                @include('front.layouts.customer.sidebar')
            </div>
        </div>


    </section>

</x-front-layout>

