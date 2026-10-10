@extends('layouts.app')

@section('content')
{{-- تحضير المتغيرات لضمان عدم حدوث خطأ في حال عدم إرسالها --}}
@php
    $isAdmission = (isset($dept) && $dept == 'قسم القبول');
    $currentType = $type ?? 'theoretical';
    $currentLevel = $level ?? null;
    $currentTerm = $term ?? null;
@endphp

<div class="min-h-screen py-12 bg-gray-50 dark:bg-slate-950" dir="rtl">
    <div class="max-w-5xl mx-auto px-6">
        
        {{-- 1. شريط المسار (Breadcrumbs) --}}
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-slate-900 p-4 rounded-full shadow-sm border border-gray-100 dark:border-slate-800">
            <div class="flex items-center gap-2 text-sm text-gray-500 font-bold">
                <i class="fas fa-home {{ $isAdmission ? 'text-orange-500' : 'text-emerald-600' }}"></i>
                <span>{{ $isAdmission ? '' : 'تخصص' }} {{ $dept }}</span>
                
                @if(!$isAdmission && $currentLevel)
                    <i class="fas fa-chevron-left text-xs"></i>
                    <span>المستوى {{ $currentLevel }}</span>
                    <i class="fas fa-chevron-left text-xs"></i>
                    <span>الترم {{ $currentTerm }}</span>
                @endif
                
                <i class="fas fa-chevron-left text-xs"></i>
                <span class="{{ $isAdmission ? 'text-orange-500' : 'text-emerald-600' }}">
                    {{ $typeLabel ?? ($currentType == 'theoretical' ? 'نظري' : ($currentType == 'exams' ? 'نماذج اختبارات' : 'عملي')) }}
                </span>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ url()->previous() }}" class="text-xs px-4 py-2 bg-gray-100 dark:bg-slate-800 rounded-full hover:bg-gray-200 transition font-bold dark:text-gray-300">
                    <i class="fas fa-arrow-right ml-1"></i> للخلف
                </a>
                <a href="{{ url('/') }}" class="text-xs px-4 py-2 {{ $isAdmission ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700' }} rounded-full hover:opacity-80 transition font-bold">
                    <i class="fas fa-home ml-1"></i> الرئيسية
                </a>
            </div>
        </div>

        {{-- 2. العنوان الرئيسي --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-sm border-r-8 {{ $isAdmission ? 'border-orange-500' : 'border-emerald-600' }} gap-4">
            <div>
                <h2 class="text-3xl font-black text-gray-900 dark:text-white">
                    {{ $typeLabel ?? ($currentType == 'theoretical' ? 'المحاضرات النظرية' : ($currentType == 'exams' ? 'قسم القبول والتسجيل' : 'المعامل العملية')) }}
                </h2>
                <p class="text-gray-500 dark:text-gray-400 font-bold mt-1">
                    {{ $isAdmission ? 'تصفح نماذج اختبارات القبول والملفات المساعدة' : 'تصفح المجلدات حسب المادة الدراسية' }}
                </p>
            </div>
            
            @if(session('success'))
                <div class="bg-emerald-100 text-emerald-700 px-6 py-3 rounded-2xl text-sm font-bold animate-bounce">
                    <i class="fas fa-check-circle ml-2"></i> {{ session('success') }}
                </div>
            @endif
        </div>

        {{-- 3. قائمة المجلدات (المواد) --}}
        <div class="space-y-6" x-data="{ activeFolder: null }">
            @forelse($subjects as $subject)
                {{-- فلترة الملفات بناءً على النوع الممرر --}}
                @php $filteredBooks = $subject->books->where('file_type', $currentType); @endphp
                
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-slate-800 overflow-hidden transition-all hover:border-gray-200">
                    
                    {{-- رأس المجلد --}}
                    <div class="flex items-center justify-between p-2">
                        <button @click="activeFolder = (activeFolder === {{ $subject->id }} ? null : {{ $subject->id }})"
                                class="flex-grow p-6 flex items-center gap-5 text-right transition-all">
                            <div class="w-14 h-14 {{ $isAdmission ? 'bg-orange-50 text-orange-600' : 'bg-emerald-50 text-emerald-600' }} rounded-2xl flex items-center justify-center text-2xl">
                                <i class="fas" :class="activeFolder === {{ $subject->id }} ? 'fa-folder-open' : 'fa-folder'"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-xl text-gray-800 dark:text-white">{{ $subject->name }}</h3>
                                <span class="text-xs font-bold italic opacity-70 {{ $isAdmission ? 'text-orange-500' : 'text-emerald-500' }}">
                                    {{ $filteredBooks->count() }} ملف متوفر
                                </span>
                            </div>
                        </button>

                        {{-- حذف المادة كاملة (للأدمن فقط) --}}
                        @auth
                            @if(auth()->user()->isAdmin())
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="ml-4" onsubmit="return confirm('تحذير: سيتم حذف المجلد بكل محتوياته نهائياً! هل أنت متأكد؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-3 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition">
                                        <i class="fas fa-folder-minus"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                        
                        <i class="fas fa-chevron-down text-gray-300 ml-8 transition-transform" :class="activeFolder === {{ $subject->id }} ? 'rotate-180' : ''"></i>
                    </div>

                    {{-- محتويات المجلد (الملفات) --}}
                    <div x-show="activeFolder === {{ $subject->id }}" x-collapse 
                         class="bg-gray-50/50 dark:bg-slate-800/50 p-6 border-t border-gray-100 dark:border-slate-800">
                        
                        <div class="grid grid-cols-1 gap-4">
                            @forelse($filteredBooks as $book)
                                <div class="bg-white dark:bg-slate-900 p-5 rounded-[1.5rem] flex items-center justify-between border border-gray-100 dark:border-slate-700 shadow-sm group">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                            <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 dark:text-gray-200">{{ $book->title }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[10px] text-gray-400 font-bold italic">بواسطة:</span>
                                                <span class="text-[10px] font-bold {{ $book->user && $book->user->isAdmin() ? 'text-blue-500' : 'text-emerald-600' }}">
                                                    {{ $book->user_name ?? 'القسم' }} 
                                                    {{ $book->user && $book->user->isAdmin() ? ' ' : '' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1">
                                        {{-- زر المعاينة --}}
                                        <a href="{{ asset('storage/' . $book->file_path) }}" 
                                           target="_blank" 
                                           class="p-2.5 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-xl transition" 
                                           title="معاينة">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                    
                                        {{-- زر التحميل --}}
                                        <a href="{{ asset('storage/' . $book->file_path) }}" 
                                           download 
                                           class="p-2.5 text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-xl transition" 
                                           title="تحميل">
                                            <i class="fas fa-download text-sm"></i>
                                        </a>                                        
                                        {{-- أزرار التحكم (أدمن أو صاحب الملف) --}}
                                        @auth
                                            @php
                                                $canControl = auth()->user()->isAdmin() || auth()->id() == $book->user_id;
                                            @endphp

                                            @if($canControl)
                                                <button onclick="openEditModal('{{ $book->id }}', '{{ $book->title }}')" class="p-2.5 text-orange-500 hover:bg-orange-50 dark:hover:bg-orange-900/30 rounded-xl transition">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </button>
                                                
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('هل تريد حذف الملف؟');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-400 font-bold italic">لا توجد ملفات في هذا القسم حالياً</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-24 bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-gray-100 dark:border-slate-800">
                    <p class="text-gray-400 text-xl font-bold">لا يوجد مواد دراسية مضافة حالياً</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

{{-- مودال التعديل --}}
<div id="editModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 backdrop-blur-sm px-4">
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 max-w-md w-full shadow-2xl border border-gray-100 dark:border-slate-800">
        <h3 class="text-2xl font-black mb-6 dark:text-white flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-edit"></i>
            </div>
            تعديل اسم الملف
        </h3>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="title" id="modalInput" 
                   class="w-full p-4 bg-gray-50 dark:bg-slate-800 rounded-2xl border-2 border-transparent focus:border-emerald-500 dark:text-white mb-6 font-bold" required>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-emerald-600 text-white py-4 rounded-2xl font-bold hover:bg-emerald-700 transition-all">حفظ التغييرات</button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-100 dark:bg-slate-800 dark:text-gray-300 py-4 rounded-2xl font-bold hover:bg-gray-200 transition-all">إلغاء</button>
            </div>
        </form>
    </div>
</div>

{{-- سكربتات التحكم --}}
<script>
    function openEditModal(id, title) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        // تأكد من صحة مسار الـ Route عندك
        form.action = `/books/${id}`;
        document.getElementById('modalInput').value = title;
        modal.classList.replace('hidden', 'flex');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.replace('flex', 'hidden');
    }

    // إغلاق المودال عند الضغط خارجه
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeEditModal();
        }
    }
</script>
@endsection