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
}
