@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 bg-gray-50 dark:bg-slate-950" dir="rtl">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-3xl font-black mb-8 dark:text-white border-r-4 border-emerald-500 pr-4">
            نماذج اختبارات القبول المتاحة
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($exams as $exam)
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl shadow-lg border border-gray-100 dark:border-slate-800">
                    <div class="flex items-center gap-4 mb-4">
                        <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                        <h3 class="font-bold dark:text-white">{{ $exam->title }}</h3>
                    </div>
                    <a href="{{ asset('storage/' . $exam->file_path) }}" target="_blank" 
                       class="block text-center bg-emerald-600 text-white py-2 rounded-xl hover:bg-emerald-700 transition">
                        عرض / تحميل الملف
                    </a>
                </div>
            @empty
                <p class="text-gray-500">لا توجد نماذج مرفوعة حالياً.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection