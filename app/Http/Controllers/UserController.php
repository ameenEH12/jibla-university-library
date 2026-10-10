<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * إضافة دكتور جديد من قبل الآدمن
     */
    public function addDoctor(Request $request)
    {
        // 1. التأكد أن المرسل هو آدمن للزيادة في الأمان
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بالقيام بهذا الإجراء');
        }

        // 2. التحقق من البيانات
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // 3. إنشاء المستخدم وتشفير الباسورد
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            // بما أن الموديل يحتوي على 'password' => 'hashed' في الـ casts
            // لارافيل سيقوم بتشفيره تلقائياً، ولكن زيادة أمان نستخدم Hash::make
            'password' => Hash::make($request->password), 
            'role'     => 'doctor', 
        ]);

        return back()->with('success', 'تم إضافة الدكتور وتشفير كلمة المرور بنجاح');
    }
}