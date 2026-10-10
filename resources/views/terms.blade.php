@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 bg-gray-50 dark:bg-slate-950" dir="rtl">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-black dark:text-white mb-12 italic">المستوى {{ $level }} - اختر الفصل الدراسي</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <a href="{{ url()->current().'/term/1' }}" 
               class="group p-12 bg-white dark:bg-slate-900 rounded-[3rem] shadow-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all border-b-8 border-emerald-600">
                <div class="text-6xl font-black text-emerald-600 mb-4 italic">01</div>
                <h3 class="text-2xl font-black dark:text-white">الفصل الدراسي الأول</h3>
                <p class="text-gray-400 font-bold mt-2 italic">First Semester</p>
            </a>

            <a href="{{ url()->current().'/term/2' }}" 
               class="group p-12 bg-white dark:bg-slate-900 rounded-[3rem] shadow-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all border-b-8 border-emerald-800">
                <div class="text-6xl font-black text-emerald-800 mb-4 italic">02</div>
                <h3 class="text-2xl font-black dark:text-white">الفصل الدراسي الثاني</h3>
                <p class="text-gray-400 font-bold mt-2 italic">Second Semester</p>
            </a>
        </div>

        <a href="javascript:history.back()" class="mt-12 inline-block text-emerald-600 font-black border-b-2 border-emerald-600 pb-1 hover:text-emerald-700">
            <i class="fas fa-arrow-right ml-2"></i> العودة لاختيار المستوى
        </a>
    </div>
</div>
@endsection