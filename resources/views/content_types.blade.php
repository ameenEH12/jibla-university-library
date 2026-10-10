@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12" dir="rtl">
    
    <div class="text-center mb-12">
        <h2 class="text-3xl font-black text-slate-800 dark:text-white mb-4">
            تصفح محتوى {{ $dept == 'admission' ? 'نماذج القبول' : 'الترم ' . $term }}
        </h2>
        <nav class="flex justify-center space-x-reverse space-x-2 text-gray-500 text-sm">
            <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">الرئيسية</a>
            <span>/</span>
            <span class="text-emerald-600 font-bold uppercase">{{ $dept }}</span>
            @if($dept !== 'admission')
                <span>/</span>
                <span>المستوى {{ $level }}</span>
            @endif
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        @if($dept === 'admission')
            <div class="lg:col-span-4 flex justify-center">
                <a href="{{ route('dept.files', [$dept, $level, $term, 'exams']) }}" 
                   class="w-full max-w-2xl glass-card p-12 rounded-[3rem] border-b-8 border-orange-500 hover:scale-[1.02] transition-all text-center shadow-2xl bg-gradient-to-br from-white to-orange-50 dark:from-slate-900 dark:to-slate-800">
                    <div class="bg-orange-100 dark:bg-orange-900/30 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-signature text-5xl text-orange-500"></i>
                    </div>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-4">نماذج اختبارات القبول</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">انقر هنا لعرض جميع نماذج امتحانات المفاضلة السابقة للجامعة</p>
                </a>
            </div>
        @else
            <a href="{{ route('dept.files', [$dept, $level, $term, 'theoretical']) }}" 
               class="glass-card p-8 rounded-3xl border-b-4 border-blue-500 hover:scale-105 transition-all text-center shadow-lg bg-white dark:bg-slate-800">
                <i class="fas fa-book-open text-4xl text-blue-500 mb-5"></i>
                <h3 class="font-black text-xl text-slate-800 dark:text-white">المحاضرات (نظري)</h3>
                <span class="text-xs text-gray-400 mt-2 block">PDFs & Documents</span>
            </a>

            <a href="{{ route('dept.files', [$dept, $level, $term, 'practical']) }}" 
               class="glass-card p-8 rounded-3xl border-b-4 border-emerald-500 hover:scale-105 transition-all text-center shadow-lg bg-white dark:bg-slate-800">
                <i class="fas fa-flask text-4xl text-emerald-500 mb-5"></i>
                <h3 class="font-black text-xl text-slate-800 dark:text-white">المعامل (عملي)</h3>
                <span class="text-xs text-gray-400 mt-2 block">Practical Worksheets</span>
            </a>

            <a href="{{ route('dept.files', [$dept, $level, $term, 'exams']) }}" 
               class="glass-card p-8 rounded-3xl border-b-4 border-orange-500 hover:scale-105 transition-all text-center shadow-lg bg-white dark:bg-slate-800">
                <i class="fas fa-file-alt text-4xl text-orange-500 mb-5"></i>
                <h3 class="font-black text-xl text-slate-800 dark:text-white">نماذج اختبارات</h3>
                <span class="text-xs text-gray-400 mt-2 block">Past Exams & Quizzes</span>
            </a>

            <a href="{{ route('dept.files', [$dept, $level, $term, 'references']) }}" 
               class="glass-card p-8 rounded-3xl border-b-4 border-purple-600 hover:scale-105 transition-all text-center shadow-lg bg-white dark:bg-slate-800">
                <i class="fas fa-atlas text-4xl text-purple-600 mb-5"></i>
                <h3 class="font-black text-xl text-slate-800 dark:text-white">المراجع والكتب</h3>
                <span class="text-xs text-gray-400 mt-2 block">Textbooks & Resources</span>
            </a>
        @endif

    </div>

    <div class="mt-16 text-center">
        <a href="javascript:history.back()" class="inline-flex items-center text-emerald-600 font-bold hover:underline">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة للخطوة السابقة
        </a>
    </div>
</div>
@endsection