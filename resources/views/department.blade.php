@extends('layouts.app')

@section('content')
@php
    /**
     * منطق م. أمين المليكي النهائي والدقيق:
     * 1. طب بشري + تخدير + طب أسنان: 5 مستويات + سنة امتياز.
     * 2. صيدلة: 5 مستويات فقط (بدون امتياز).
     * 3. مختبرات + تمريض + قبالة: 4 مستويات + سنة امتياز.
     */
    
    // 1. تحديد الأقسام التي تدرس 5 سنوات
    $fiveYearDepts = ['medicine', 'anesthesia', 'dentistry', 'pharmacy'];
    $maxLevel = in_array($dept, $fiveYearDepts) ? 5 : 4;

    // 2. تحديد الأقسام التي لديها سنة امتياز (الكل ما عدا الصيدلة)
    $hasInternship = ($dept !== 'pharmacy');
@endphp

<div class="min-h-screen py-12 bg-gray-50 dark:bg-slate-950" dir="rtl" 
     x-data="{ 
        step: 'levels', 
        selectedLevel: '', 
        selectedTerm: '',
        department: '{{ $dept }}'
     }">

    <div class="max-w-4xl mx-auto px-6">
        
        <div class="mb-12 border-r-8 border-emerald-600 pr-6 relative">
            <template x-if="step !== 'levels'">
                <button @click="step = (step === 'types' ? (selectedLevel === 'internship' ? 'levels' : 'terms') : 'levels')" 
                        class="absolute left-0 top-0 bg-white dark:bg-slate-900 px-4 py-2 rounded-2xl shadow-md text-emerald-600 font-bold hover:scale-105 transition-all border border-emerald-100 dark:border-slate-800">
                    <i class="fas fa-arrow-right ml-2"></i> رجوع
                </button>
            </template>

            <h2 class="text-4xl font-black text-gray-900 dark:text-white italic">
                <span x-show="step === 'levels'">قسم {{ $department_name }}</span>
                <span x-show="step === 'terms'" x-text="selectedLevel === 'internship' ? 'سنة الامتياز' : 'المستوى ' + selectedLevel"></span>
                <span x-show="step === 'types'" x-text="selectedLevel === 'internship' ? 'محتوى الامتياز' : 'الترم ' + (selectedTerm == 1 ? 'الأول' : 'الثاني')"></span>
            </h2>
            <p class="text-emerald-600 font-bold mt-2" x-text="
                step === 'levels' ? 'اختر المستوى الدراسي للبدء' : 
                (step === 'terms' ? 'اختر الفصل الدراسي (الترم)' : 'اختر نوع المحتوى الذي تبحث عنه')
            "></p>
        </div>

        <div x-show="step === 'levels'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-12">
            
            @for($i = 1; $i <= $maxLevel; $i++)
                <div @click="selectedLevel = '{{ $i }}'; step = 'terms'" 
                     class="cursor-pointer group p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl border-2 border-transparent hover:border-emerald-500 transition-all flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 rounded-3xl flex items-center justify-center text-4xl font-black mb-4 group-hover:scale-110 transition-transform">
                        {{ $i }}
                    </div>
                    <span class="text-xl font-black text-gray-800 dark:text-white">المستوى</span>
                    <span class="text-sm font-bold text-gray-400 mt-1 italic group-hover:text-emerald-500">Level {{ $i }}</span>
                </div>
            @endfor

            @if($hasInternship)
                <div @click="selectedLevel = 'internship'; step = 'types'; selectedTerm = '0'"
                     class="cursor-pointer relative overflow-hidden group p-8 bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-[2.5rem] shadow-2xl flex flex-col items-center justify-center text-white transition-all hover:-translate-y-2">
                    <i class="fas fa-user-graduate text-4xl mb-3"></i>
                    <span class="text-xl font-black">سنة الامتياز</span>
                    <span class="text-[10px] font-bold opacity-80 mt-1 italic text-center">Internship Year</span>
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl rotate-12">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            @endif
        </div>

        <div x-show="step === 'terms'" x-transition:enter="transition ease-out duration-300" class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div @click="selectedTerm = 1; step = 'types'" 
                 class="cursor-pointer group p-10 bg-white dark:bg-slate-900 rounded-[3rem] shadow-xl border-b-8 border-emerald-500 flex items-center gap-6 hover:scale-105 transition-all">
                <div class="text-5xl text-emerald-600 font-black italic">01</div>
                <div>
                    <h3 class="text-2xl font-black dark:text-white">الفصل الأول</h3>
                    <p class="text-gray-400 font-bold italic text-sm">First Semester</p>
                </div>
            </div>

            <div @click="selectedTerm = 2; step = 'types'" 
                 class="cursor-pointer group p-10 bg-white dark:bg-slate-900 rounded-[3rem] shadow-xl border-b-8 border-emerald-700 flex items-center gap-6 hover:scale-105 transition-all">
                <div class="text-5xl text-emerald-700 font-black italic">02</div>
                <div>
                    <h3 class="text-2xl font-black dark:text-white">الفصل الثاني</h3>
                    <p class="text-gray-400 font-bold italic text-sm">Second Semester</p>
                </div>
            </div>
        </div>

        <div x-show="step === 'types'" x-transition:enter="transition ease-out duration-300" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <a :href="'/dept/' + department + '/level/' + selectedLevel + '/term/' + selectedTerm + '/type/theoretical'"
               class="group p-8 bg-white dark:bg-slate-900 rounded-[2rem] shadow-lg text-center hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all border-t-4 border-blue-500">
                <i class="fas fa-book-open text-4xl text-blue-500 mb-4 group-hover:scale-110 transition"></i>
                <h4 class="text-xl font-black dark:text-white">المحتوى النظري</h4>
                <p class="text-xs text-gray-400 mt-2 italic font-bold">Lectures & Books</p>
            </a>

            <a :href="'/dept/' + department + '/level/' + selectedLevel + '/term/' + selectedTerm + '/type/practical'"
               class="group p-8 bg-white dark:bg-slate-900 rounded-[2rem] shadow-lg text-center hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all border-t-4 border-emerald-500">
                <i class="fas fa-microscope text-4xl text-emerald-500 mb-4 group-hover:scale-110 transition"></i>
                <h4 class="text-xl font-black dark:text-white">المحتوى العملي</h4>
                <p class="text-xs text-gray-400 mt-2 italic font-bold">Practical & Labs</p>
            </a>

            <a :href="'/dept/' + department + '/level/' + selectedLevel + '/term/' + selectedTerm + '/type/exams'"
               class="group p-8 bg-white dark:bg-slate-900 rounded-[2rem] shadow-lg text-center hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-all border-t-4 border-orange-500">
                <i class="fas fa-file-signature text-4xl text-orange-500 mb-4 group-hover:scale-110 transition"></i>
                <h4 class="text-xl font-black dark:text-white">نماذج اختبارات</h4>
                <p class="text-xs text-gray-400 mt-2 italic font-bold">Past Exams & Quizzes</p>
            </a>
        </div>
    </div>
</div>
@endsection