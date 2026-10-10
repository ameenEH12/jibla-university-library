@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 bg-gray-50 dark:bg-slate-950" dir="rtl">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-10 text-right">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white">الملف الشخصي للدكتور</h2>
            <p class="text-emerald-600 font-bold">بياناتك المسجلة في النظام</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-1">
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-xl border border-gray-100 dark:border-slate-800 text-center">
                    <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h3 class="text-xl font-black dark:text-white">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-400 text-sm mb-6">{{ auth()->user()->email }}</p>
                    <span class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-black">حساب دكتور مُحقق</span>
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800">
                        <p class="text-gray-400 font-bold text-xs mb-2">إجمالي المواد المتوفرة</p>
                        <p class="text-3xl font-black text-emerald-600">{{ $subjectsCount }}</p>
                    </div>
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800">
                        <p class="text-gray-400 font-bold text-xs mb-2">ملفات قمت برفعها</p>
                        <p class="text-3xl font-black text-blue-600">{{ $filesCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-xl border border-gray-100 dark:border-slate-800 text-right">
                    <h4 class="text-lg font-black dark:text-white mb-6 italic">معلومات تقنية</h4>
                    
                    <div class="space-y-4 font-bold">
                        <div class="flex justify-between p-4 bg-gray-50 dark:bg-slate-800 rounded-2xl">
                            <span class="text-gray-500">معرف المستخدم (ID)</span>
                            <span class="text-gray-800 dark:text-white">#{{ auth()->id() }}</span>
                        </div>
                        <div class="flex justify-between p-4 bg-gray-50 dark:bg-slate-800 rounded-2xl">
                            <span class="text-gray-500">تاريخ التسجيل</span>
                            <span class="text-gray-800 dark:text-white">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('profile') }}" class="block w-full bg-emerald-600 text-white text-center py-4 rounded-2xl font-black hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                            انتقل لمركز الرفع الآن
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection