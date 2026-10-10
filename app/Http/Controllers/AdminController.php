<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function editDoctor(Request $request)
    {
        // فحص يدوي بديل للميدل وير
        if (auth()->user()->role !== 'admin') {
            abort(403, 'غير مسموح لك بالقيام بهذه العملية');
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $doctor = User::where('email', $request->email)->first();
        $doctor->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'تم تحديث بيانات الدكتور بنجاح');
    }
public function deleteDoctor(Request $request)
{
    $email = $request->input('email');
    $doctor = User::where('email', $email)->first();

    if ($doctor) {
        // --- الحل هنا ---
        // 1. خيار حذف كتب الدكتور أولاً:
        $doctor->books()->delete(); 
        
        // 2. أو خيار نقل كتبه لأدمن آخر (مثلاً id=1)
        // \App\Models\Book::where('user_id', $doctor->id)->update(['user_id' => 1]);

        // الآن يمكن حذف الدكتور بأمان
        $doctor->delete();
        return redirect()->back()->with('success', 'تم حذف الدكتور وكتبه بنجاح');
    }

    return redirect()->back()->with('error', 'الدكتور غير موجود');
}
}