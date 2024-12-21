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

    <!-- Displaying user addresses at the top -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="mb-4">Your Addresses</h4>
                    <ul class="list-group">
                        @forelse ($addresses as $address)
                            <li class="list-group-item">
                                <!-- Collapse Button to show/hide address details -->
                                <a class="d-block" data-bs-toggle="collapse" href="#address-{{ $address->id }}"
                                    role="button" aria-expanded="false" aria-controls="address-{{ $address->id }}">
                                    <h5>{{ $address->first_name }} {{ $address->last_name }}</h5>
                                </a>

                                <!-- Collapsible Content for Address Details -->
                                <div class="collapse" id="address-{{ $address->id }}">
                                    <p>{{ $address->street_address }}, {{ $address->city }},
                                        {{ $address->postal_code }}</p>
                                    <p>{{ $address->state }}, {{ $address->country }}</p>
                                    <p>Phone: {{ $address->phone_number }}</p>
                                    <p>Email: {{ $address->email }}</p>
                                    <p>Status:
                                        @if ($address->default)
                                            <strong>Default Address</strong>
                                        @else
                                            <form action="{{ route('customer.address.setDefault', $address->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">Set as
                                                    Default</button>
                                            </form>
                                        @endif
                                    </p>
                                    <p><a href="{{ route('customer.address.edit', $address->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a></p>
                                    <p>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-address-id="{{ $address->id }}">
                                            Delete
                                        </button>
                                    </p>
                                </div>
                            </li>


                               <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this address?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="{{ route('customer.address.delete', $address->id) }}"
                        method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
                        @empty
                            <li class="list-group-item">You have no saved addresses.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Form for adding a new address -->
    <section class="py-5">
        <div class="container">
            <div class="row" id="addressSection">
                <div class="col-lg-8">
                    <h4 class="mb-4">Add New Address</h4>
                    <form action="{{ route('customer.address.store') }}" method="POST">
                        @csrf
                        <div class="checkout-steps-form-style-1">
                            <ul id="accordionExample">
                                <li>

                                    <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="true" aria-controls="collapseThree"><button id="toggleButton"
                                            type="button" class="btn btn-secondary">Add Address</button></h6>
                                    <section class="checkout-steps-form-content collapse show" id="addressDetails"
                                        style="display: none;" aria-labelledby="headingThree"
                                        data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>User Name</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="first_name" placeholder="First Name" />
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input name="last_name" placeholder="Last Name" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Email Address</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="email" placeholder="Email Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Phone Number</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="phone_number" placeholder="Phone Number" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Mailing Address</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="street_address"
                                                            placeholder="Mailing Address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>City</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="city" placeholder="City" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Post Code</label>
                                                    <div class="form-input form">
                                                        <x-form.input name="postal_code" placeholder="Post Code" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Region/State</label>
                                                    <div class="select-items">
                                                        <x-form.input name="state" placeholder="State" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Country</label>
                                                    <div class="form-input form">
                                                        <x-form.select name="country" :options="$countries" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-checkbox checkbox-style-3">
                                                    <input type="checkbox" id="checkbox-default" name="default"
                                                        value="1">
                                                    <label for="checkbox-default"><span></span></label>
                                                    <p>Set this address as default.</p>
                                                </div>
                                            </div>


                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Address</button>
                                    </section>
                                </li>


                            </ul>

                        </div>

                    </form>
                </div>
                <!-- SIDEBAR -->
                <div class="col-lg-4">
                    @include('front.layouts.customer.sidebar')
                </div>
            </div>
        </div>
    </section>

 
    <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            var addressDetails = document.getElementById('addressDetails');
            if (addressDetails.style.display === 'none' || addressDetails.style.display === '') {
                addressDetails.style.display = 'block';
            } else {
                addressDetails.style.display = 'none';
            }
        });
    </script>
    
</x-front-layout>
