@extends('dashboard.layouts.master')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
            @can('create customer')
            <div class="ml-auto">
                <a href="{{ route('dashboard.customers.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new customer</span>
                </a>
            </div>
            @endcan
        </div>

        @include('dashboard.customers.filter.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email & Mobile</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>
                         
                            @if ($customer->media != '')
                        
                                <img src="{{ asset('assets/customers/'. $customer->media->file_name) }}" width="60" height="60" alt="{{ $customer->name }}">
                            @else
                                <img src="{{ asset('assets/users/avatar.svg') }}" width="60" height="60" alt="{{ $customer->name }}">
                            @endif
                        </td>
                        <td>
                            {{ $customer->name }}
                        </td>
                        <td>
                            {{ $customer->email }}<br>
                            {{ $customer->mobile }}
                        </td>
                      
                        <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @can('update customer')
                                <a href="{{ route('dashboard.customers.show', $customer->id) }}" class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @endcan
                                @can('update customer')
                                <a href="{{ route('dashboard.customers.edit', $customer->id) }}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete customer')
                                <a href="javascript:void(0);" onclick="if (confirm('Are you sure to delete this record?')) { document.getElementById('delete-customer-{{ $customer->id }}').submit(); } else { return false; }" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @endcan
                            </div>
                            <form action="{{ route('dashboard.customers.destroy', $customer->id) }}" method="post" id="delete-customer-{{ $customer->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No customers found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $customers->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection
