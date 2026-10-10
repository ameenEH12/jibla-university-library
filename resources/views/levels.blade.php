@extends('layouts.app')

@section('content')
@php
    /**
     * منطق م. أمين المليكي المعتمد (النهائي والدقيق):
     * 1. بشري، تخدير، أسنان، صيدلة = 5 مستويات.
     * 2. مختبرات، تمريض، قبالة = 4 مستويات.
     * 3. الامتياز للكل ما عدا الصيدلة.
     */
    $fiveYearDepts = ['medicine', 'anesthesia', 'dentistry', 'pharmacy'];
    $maxLevel = in_array($dept, $fiveYearDepts) ? 5 : 4;
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
                <span x-show="step === 'types'" x-text="selectedLevel === 'internship' ? 'المكتبة المرجعية' : 'الترم ' + (selectedTerm == 1 ? 'الأول' : 'الثاني')"></span>
            </h2>
            <p class="text-emerald-600 font-bold mt-2">جامعة جبلة للعلوم الطبية</p>
        </div>

        <div x-show="step === 'levels'" x-transition class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-12">
            @for($i = 1; $i <= $maxLevel; $i++)
                <div @click="selectedLevel = '{{ $i }}'; step = 'terms'" 
                     class="cursor-pointer group p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl border-2 border-transparent hover:border-emerald-500 transition-all flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 rounded-2xl flex items-center justify-center text-3xl font-black mb-4 group-hover:scale-110 transition">
                        {{ $i }}
                    </div>
                    <span class="text-lg font-black text-gray-800 dark:text-white">المستوى {{ $i }}</span>
                </div>
            @endfor

            @if($hasInternship)
                <div @click="selectedLevel = 'internship'; step = 'types'; selectedTerm = '0'"
                     class="cursor-pointer group p-8 bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-[2.5rem] shadow-2xl flex flex-col items-center justify-center text-white transition-all hover:-translate-y-2">
                    <i class="fas fa-user-graduate text-3xl mb-3"></i>
                    <span class="text-lg font-black">سنة الامتياز</span>
                </div>
            @endif
        </div>

        <div x-show="step === 'terms'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div @click="selectedTerm = 1; step = 'types'" class="cursor-pointer group p-10 bg-white dark:bg-slate-900 rounded-[3rem] shadow-xl border-b-8 border-emerald-500 flex items-center gap-6 hover:scale-[1.02] transition">
                <div class="text-5xl text-emerald-600 font-black italic">01</div>
                <h3 class="text-2xl font-black dark:text-white">الفصل الأول</h3>
            </div>
            <div @click="selectedTerm = 2; step = 'types'" class="cursor-pointer group p-10 bg-white dark:bg-slate-900 rounded-[3rem] shadow-xl border-b-8 border-emerald-700 flex items-center gap-6 hover:scale-[1.02] transition">
                <div class="text-5xl text-emerald-700 font-black italic">02</div>
                <h3 class="text-2xl font-black dark:text-white">الفصل الثاني</h3>
            </div>
        </div>

        <div x-show="step === 'types'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            
            <a :href="'/dept/' + department + '/level/' + selectedLevel + '/term/' + selectedTerm + '/type/theoretical'"
               class="p-6 bg-white dark:bg-slate-900 rounded-[2rem] shadow-lg flex items-center gap-5 border-r-4 border-blue-500 hover:bg-blue-50 transition">
                <i class="fas fa-book-open text-3xl text-blue-500"></i>
                <div>
                    <h4 class="text-lg font-black dark:text-white">المحتوى النظري</h4>
                    <p class="text-xs text-gray-400 font-bold italic">Lectures & Slides</p>
                </div>
            </a>

            <a :href="'/dept/' + department + '/level/' + selectedLevel + '/term/' + selectedTerm + '/type/practical'"
               class="p-6 bg-white dark:bg-slate-900 rounded-[2rem] shadow-lg flex items-center gap-5 border-r-4 border-emerald-500 hover:bg-emerald-50 transition">
                <i class="fas fa-microscope text-3xl text-emerald-500"></i>
                <div>
                    <h4 class="text-lg font-black dark:text-white">المحتوى العملي</h4>
                    <p class="text-xs text-gray-400 font-bold italic">Practical & Labs</p>
                </div>
            </a>

            <a :href="'/dept/' + department + '/level/' + selectedLevel + '/term/' + selectedTerm + '/type/references'"
               class="p-6 bg-white dark:bg-slate-900 rounded-[2rem] shadow-lg flex items-center gap-5 border-r-4 border-purple-500 hover:bg-purple-50 transition">
                <i class="fas fa-library text-3xl text-purple-500"></i>
                <div>
                    <h4 class="text-lg font-black dark:text-white">الكتب والمراجع</h4>
                    <p class="text-xs text-gray-400 font-bold italic">Books & References</p>
                </div>
            </a>

            <a x-show="selectedLevel !== 'internship'" 
               :href="'/dept/' + department + '/level/' + selectedLevel + '/term/' + selectedTerm + '/type/exams'"
               class="p-6 bg-white dark:bg-slate-900 rounded-[2rem] shadow-lg flex items-center gap-5 border-r-4 border-orange-500 hover:bg-orange-50 transition">
                <i class="fas fa-file-signature text-3xl text-orange-500"></i>
                <div>
                    <h4 class="text-lg font-black dark:text-white">نماذج اختبارات</h4>
                    <p class="text-xs text-gray-400 font-bold italic">Past Exams</p>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection