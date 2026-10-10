<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLogin()
    {
        // إذا كان المستخدم مسجل دخول أصلاً، وجهه للمكان الصحيح (الرئيسية)
        if (Auth::check()) {
            return $this->redirectUserBasedOnRole();
        }
        return view('auth.login');
    }

    /**
     * تسجيل دخول يدوي (دكاترة وآدمن)
     */
    public function manualLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            // توليد جلسة جديدة فوراً لمنع خطأ 419 وتأمين المستخدم
            $request->session()->regenerate();
            
            return $this->redirectUserBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'البيانات المدخلة لا تطابق سجلاتنا.',
        ])->withInput($request->only('email'));
    }

    /**
     * دالة استعادة كلمة المرور (إرسال معلومات للادمن)
     */
    public function handlePasswordRequest(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        // ملاحظة: يمكنك هنا إضافة كود لحفظ الطلب في قاعدة البيانات 
        // أو إرساله عبر البريد للإدارة.
        
        // العودة مع رسالة نجاح تظهر في الصفحة
        return back()->with('status', 'تم إرسال طلبك للإدارة بنجاح، سيتم التواصل معك قريباً.');
    }

    /**
     * تسجيل دخول جوجل (طلاب)
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // ابحث عن المستخدم أولاً لتجنب خطأ المتغير غير المعرف $user
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                $user = $existingUser;
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                ]);
            } else {
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    'password'  => Hash::make(Str::random(16)), 
                    'role'      => 'student', 
                ]);
            }

            Auth::login($user, true);
            
            // تجديد الجلسة بعد دخول جوجل
            request()->session()->regenerate();

            return redirect()->intended('/');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'حدث خطأ أثناء تسجيل الدخول عبر جوجل: ' . $e->getMessage());
        }
    }

    /**
     * دالة مساعدة للتوجيه بناءً على الرتبة
     */
    protected function redirectUserBasedOnRole()
    {
        return redirect()->to('/');
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        // مسح بيانات الجلسة الحالية تماماً
        $request->session()->invalidate();
        
        // إعادة توليد توكن CSRF جديد
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}