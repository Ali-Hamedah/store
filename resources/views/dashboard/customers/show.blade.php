@extends('dashboard.layouts.master')
@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Customer Details ({{ $customer->name }})</h6>
            <a href="{{ route('dashboard.customers.index') }}" class="btn btn-primary">
                <i class="fa fa-home mr-1"></i> Customers
            </a>
        </div>
        <div class="card-body">
            <!-- Customer details section -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">First Name</label>
                        <p class="form-control-plaintext">{{ $customer->name }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <p class="form-control-plaintext">{{ $customer->email }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mobile" class="font-weight-bold">Mobile</label>
                        <p class="form-control-plaintext">{{ $customer->phone_number }}</p>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="birthday" class="font-weight-bold">Birthday</label>
                        <p class="form-control-plaintext">{{ $customer->birthday }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="country" class="font-weight-bold">Country</label>
                        <p class="form-control-plaintext">{{ $customer->country }}</p>
                    </div>
                </div>
               <div class="col-md-4">
                    <div class="form-group">
                        <label for="gender" class="font-weight-bold">Gender</label>
                        <p class="form-control-plaintext">{{ ucfirst($customer->gender) }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="image" class="font-weight-bold">Image</label>
                        @if($customer->image)
                            <img src="{{ asset('uploads/customers/' . $customer->image) }}" alt="Customer Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="addresses" class="font-weight-bold">Addresses</label>
                        <ul class="list-group">
                            @foreach ($customer->addresses as $address)
                                <li class="list-group-item">
                                    <!-- Collapse Button to show/hide address details -->
                                    <a class="d-block" data-bs-toggle="collapse" href="#address-{{ $address->id }}"
                                       role="button" aria-expanded="false" aria-controls="address-{{ $address->id }}">
                                        <h5>{{ $address->street_address }}, {{ $address->city }},
                                            {{ $address->postal_code }}</h5>
                                    </a>
                        
                                    <div class="collapse" id="address-{{ $address->id }}">
                                        <p>{{ $address->street_address }}, {{ $address->city }},
                                            {{ $address->postal_code }}</p>
                                        <p>{{ $address->state }}, {{ $address->country }}</p>
                                        <p>Phone: {{ $address->phone_number }}</p>
                                        <p>Email: {{ $address->email }}</p>
                                        <p>Status:  {!! $address->default == 1 ? '<span style=color:orange>Default Address</span>' : '' !!}</p>

                                        
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const collapseButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');
    
    collapseButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const target = document.getElementById(button.getAttribute('aria-controls'));
            if (target.classList.contains('collapse')) {
                target.classList.toggle('show');
            }
        });
    });
});
    </script>
@endpush