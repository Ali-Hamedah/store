<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google Callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // ابحث عن المستخدم أو قم بإنشائه
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt('password'), // ضع قيمة افتراضية لأن Google لا يوفر كلمات مرور
                ]
            );

            // تسجيل الدخول
            Auth::login($user);

            return redirect()->intended('/');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'حدث خطأ أثناء تسجيل الدخول عبر Google.');
        }
        
    }
    public function chooseLoginMethod()
    {
        return view('front.auth.login');
    }

    public function chooseRegistrationMethod()
    {
        return view('front.auth.register');
    }
    
}
