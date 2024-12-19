<?php

namespace App\Http\Controllers\Front;

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
use App\Http\Requests\Front\ProfileRequest;

class CustomerController extends Controller
{

    public function dashboard()
    {
        return view('front.customer.index');
    }

    public function profile()
    {
        return view('front.customer.profile');
    }

    public function update_profile(Request $request)
{
    $user = auth()->user();

    $input = []; // Initialize the input array
    $input['name'] = $request->name;
    $input['email'] = $request->email;
    $input['phone_number'] = $request->phone_number;

    if (trim($request->password) != '') {
        $input['password'] = bcrypt($request->password);
    }
    // Handle image upload
    if ($request->hasFile('image')) {
        $customerName = Str::slug($request->name, '-');
        $file_name = $customerName . '_' . time() . '.' . $request->image->getClientOriginalExtension();
        $file_size = $request->image->getSize();
        $file_type = $request->image->getMimeType();
  // Delete the old image if it exists
  if ($user->media && File::exists(public_path('assets/customers/' . $user->media->file_name))) {
    File::delete(public_path('assets/customers/' . $user->media->file_name));
}
        // Move the uploaded file to the destination directory
        $request->image->move(public_path('assets/customers/'), $file_name);
        // Create or update media record
        $user->media()->update( [
            'file_name' => $file_name,
            'file_size' => $file_size,
            'file_type' => $file_type,
            'file_status' => true,
            'file_sort' => 1,
        ]);
    }
    // Update user details
    $user->update($input);

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

public function addresses()
{
    // جلب العناوين الخاصة بالمستخدم
    $addresses = auth()->user()->addresses()->orderByDesc('default')->get();
    // تأكد من استخدام auth() بدلاً من User()
    
    // جلب أسماء الدول
    $countries = Countries::getNames();
    
    // تمرير العناوين والدول إلى الـ view
    return view('front.customer.addresses', compact('addresses', 'countries'));
}

public function store(Request $request)
{

    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone_number' => 'required|string|max:20',
        'street_address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:20',
        'state' => 'nullable|string|max:255',
        'country' => 'required|string|max:255',
        'default' => 'nullable|boolean',
    
    ]);
   
    $isDefault = $request->has('default') && $request->input('default') == '1' ? true : false;

    $address = auth()->user()->addresses()->create([
      
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'street_address' => $request->street_address,
        'city' => $request->city,
        'postal_code' => $request->postal_code,
        'state' => $request->state,
        'country' => $request->country,
        'default' => $isDefault ? 1 : 0, 
    ]);
    if ($isDefault) {
        auth()->user()->addresses()->where('id', '!=', $address->id)->update(['default' => 0]);
    }

    // العودة إلى الصفحة السابقة مع رسالة نجاح
    return redirect()->back()->with('success', 'Address added successfully!');
}


public function addressEdit($id)
{
    $countries = Countries::getNames();
    // الحصول على العنوان باستخدام العلاقة مع المستخدم الحالي والتأكد من وجوده
    $address = auth()->user()->addresses()->findOrFail($id);

    // تمرير العنوان فقط إلى الـ view بدلاً من جميع العناوين
    return view('front.customer.address_edit', compact('address', 'countries'));
}

public function addressUpdate(Request $request, $id)
{
    // التحقق من صحة البيانات
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone_number' => 'required|string|max:20',
        'street_address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
        'state' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'default' => 'nullable|boolean', // إذا كنت تستخدم خانة الاختيار لتحديد العنوان الافتراضي
    ]);

    // العثور على العنوان بناءً على المعرف الخاص بالمستخدم
    $address = auth()->user()->addresses()->findOrFail($id);

    // تحديث البيانات
    $address->update([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'email' => $validatedData['email'],
        'phone_number' => $validatedData['phone_number'],
        'street_address' => $validatedData['street_address'],
        'city' => $validatedData['city'],
        'postal_code' => $validatedData['postal_code'],
        'state' => $validatedData['state'],
        'country' => $validatedData['country'],
        'default' => $validatedData['default'] ?? 0, // إذا لم يتم تحديد الخيار، سيتم وضعه كـ 0
    ]);

    // إعادة التوجيه إلى صفحة عناوين المستخدم مع رسالة نجاح
    return redirect()->back()->with('success', 'Address updated successfully.');
}

public function setDefaultAddress($addressId)
{
    $user = auth()->user();

    // Set all other addresses to non-default
    $user->addresses()->update(['default' => false]);

    // Set the selected address as default
    $address = $user->addresses()->findOrFail($addressId);
    $address->update(['default' => true]);

    return redirect()->back()->with('success', 'Address set as default.');
}

public function addressDelete($id)
{
    // العثور على العنوان الخاص بالمستخدم
    $address = auth()->user()->addresses()->findOrFail($id);

    // حذف العنوان
    $address->delete();

    // إعادة التوجيه إلى صفحة العناوين مع رسالة نجاح
    return redirect()->route('customer.addresses')->with('success', 'Address deleted successfully.');
}


public function orders()
{
    return view('front.customer.orders');
}


}


