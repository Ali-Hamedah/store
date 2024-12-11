<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Symfony\Component\Intl\Countries;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:view customer|create customer|edit customer|delete customer'], ['only' => ['index', 'show']]);
        $this->middleware(['permission:create customer'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:update customer'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete customer'], ['only' => ['destroy']]);
    }

    public function index()
    {
      
        $customers = User::where('type', 'user')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);
        return view('dashboard.customers.index', compact('customers'));
    }

    public function create()
    {
        $countries = Countries::getNames();
        return view('dashboard.customers.create', compact('countries'));
    }

    public function store(CustomerRequest $request, User $customer)
    {
        // if (!auth()->user()->ability('admin', 'create_customers')) {
        //     return redirect('admin/index');
        // }

        $input = $request->only([
            'name', 'email', 'phone_number', 
            'birthday', 'country', 'street_address'
        ]);
        $input['password'] = bcrypt($request->password);
    
        // Create the customer (User) object
        $customer = User::create($input);
    
        // If an image is uploaded, handle the media association
        if ($request->hasFile('image')) {
            $customerName = Str::slug($request->name, '-');
            $file_name = $customerName . '_' . time() . '.' . $request->image->getClientOriginalExtension();
            $file_size = $request->image->getSize();
            $file_type = $request->image->getMimeType();
    
            // Move the uploaded file to the public directory
            $request->image->move(public_path('assets/customers/'), $file_name);
    
            // Create the media record associated with the customer
            $customer->media()->create([
                'file_name' => $file_name,
                'file_size' => $file_size,
                'file_type' => $file_type,
                'file_status' => true,
                'file_sort' => 1,
            ]);
        }
    
        // Mark the customer's email as verified
        $customer->markEmailAsVerified();

        return redirect()->route('dashboard.customers.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }


    public function show(User $customer)
    {
        // if (!auth()->user()->ability('admin', 'display_customers')) {
        //     return redirect('admin/index');
        // }

        return view('dashboard.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        // if (!auth()->user()->ability('admin', 'update_customers')) {
        //     return redirect('admin/index');
        // }
$countries = Countries::getNames();
        return view('dashboard.customers.edit', compact('customer', 'countries'));
    }

    public function update(CustomerRequest $request, User $customer)
    {
        // if (!auth()->user()->ability('admin', 'update_customers')) {
        //     return redirect('admin/index');
        // }
   

        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['phone_number'] = $request->phone_number;
        $input['birthday'] = $request->birthday;
        $input['country'] = $request->country;
        $input['street_address'] = $request->street_address;
        if (trim($request->password) != ''){
            $input['password'] = bcrypt($request->password);
        }

        $customerName = Str::slug($request->name, '-');
        if ($request->hasFile('image')) {
$file_name = $customerName . '_' . time() . '_' . '.' . $request->image->getClientOriginalExtension();
            $file_size = $request->image->getSize();
            $file_type = $request->image->getMimeType();
            // $path = public_path('assets/customers/' . $file_name);
            $request->image->move(public_path('assets/customers/'), $file_name);
            $customer->update($input);
            $customer->media()->create([
                'file_name' => $file_name,
                'file_size' => $file_size,
                'file_type' => $file_type,
                'file_status' => true,
                'file_sort' => 1,
            ]);
      

        return redirect()->route('dashboard.customers.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }
}

    public function destroy(User $customer)
    {
        // if (!auth()->user()->ability('admin', 'delete_customers')) {
        //     return redirect('admin/index');
        // }

        if (File::exists('assets/users/'. $customer->user_image)){
            unlink('assets/users/'. $customer->user_image);
        }
        $customer->delete();

        return redirect()->route('dashboard.customers.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function remove_image(Request $request)
    {
        // if (!auth()->user()->ability('admin', 'delete_customers')) {
        //     return redirect('admin/index');
        // }

        $customer = User::findOrFail($request->customer_id);
        if (File::exists('assets/users/'. $customer->user_image)){
            unlink('assets/users/'. $customer->user_image);
            $customer->user_image = null;
            $customer->save();
        }
        return true;
    }

    public function get_customers()
    {
        $customers = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })
            ->when(\request()->input('query') != '', function ($query) {
                $query->search(\request()->input('query'));
            })
            ->get(['id', 'first_name', 'last_name', 'email'])->toArray();

        return response()->json($customers);
    }
}
