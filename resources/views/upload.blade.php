<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="darkModeLogic()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة الرفع | جامعة جبلة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { 'primary-dark': '#12372A', 'accent-gold': '#AD8B3A' } } }
        }
    </script>
    <style>
        body { font-family: 'Tajawal', sans-serif; transition: background-color 0.3s ease; }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .dark .glass-card { background: rgba(15, 23, 42, 0.9); }
        [x-cloak] { display: none !important; }
        input::placeholder { font-size: 0.85rem; opacity: 0.7; }
    </style>
</head>
<body class="bg-[#f4f7f6] dark:bg-slate-950 min-h-screen pb-12 text-right">

    <div class="max-w-2xl mx-auto pt-6 px-4 md:px-6">
        @if(session('success'))
            <div class="bg-emerald-500 text-white p-4 mb-6 rounded-2xl shadow-lg flex items-center animate-bounce">
                <i class="fas fa-check-circle ml-3 text-xl"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-black text-emerald-900 dark:text-white">بوابة الرفع</h1>
            <div class="flex gap-2">
                <button @click="toggleDark()" class="p-3 bg-white dark:bg-slate-900 rounded-2xl shadow hover:text-emerald-600 transition dark:text-white text-emerald-900">
                    <i class="fas" :class="isDark ? 'fa-sun' : 'fa-moon'"></i>
                </button>
                <a href="/" class="p-3 bg-white dark:bg-slate-900 rounded-2xl shadow hover:text-emerald-600 transition dark:text-white text-emerald-900">
                    <i class="fas fa-home"></i>
                </a>
            </div>
        </div>
    </div>

    <main class="max-w-2xl mx-auto px-4 md:px-6" x-data="{ uploading: false }">
        <div class="glass-card p-6 md:p-8 rounded-[2.5rem] shadow-2xl border border-white/20 dark:border-slate-800">
            
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-emerald-700 rounded-3xl flex items-center justify-center text-white text-3xl mx-auto mb-4 shadow-lg shadow-emerald-700/30">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <h2 class="text-xl md:text-2xl font-black dark:text-white text-emerald-900">إضافة محتوى جديد</h2>
                <p class="text-xs text-gray-500 mt-2 font-medium">يرجى ملء البيانات بدقة لضمان سهولة الوصول للملفات</p>
            </div>

            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" 
                  @submit="uploading = true" class="space-y-5">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-right">
                    <div>
                        <label class="block text-xs font-black mb-2 mr-2 dark:text-gray-300 text-emerald-700 uppercase tracking-wide">عنوان المحتوى</label>
                        <input type="text" name="title" required placeholder="مثلاً: المحاضرة الأولى"
                               class="w-full bg-gray-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 rounded-2xl py-3 px-4 dark:text-white text-sm transition-all outline-none font-bold">
                    </div>
                    <div id="subjectContainer">
                        <label class="block text-xs font-black mb-2 mr-2 dark:text-gray-300 text-emerald-700 uppercase tracking-wide">اسم المادة</label>
                        <input type="text" name="subject_name" id="subjectInput" required placeholder="مثلاً: Anatomy"
                               class="w-full bg-gray-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 rounded-2xl py-3 px-4 dark:text-white text-sm transition-all outline-none font-bold text-left">
                    </div>
                </div>

                <div class="text-right">
                    <label class="block text-xs font-black mb-2 mr-2 dark:text-gray-300 text-emerald-700 uppercase tracking-wide">القسم / نوع المحتوى العام</label>
                    <select name="department" id="deptSelect" onchange="updateUI()" required
                            class="w-full bg-gray-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 rounded-2xl py-3 px-3 dark:text-white text-sm font-bold transition-all outline-none cursor-pointer">
                        <option value="medicine">الطب البشري</option>
                        <option value="dentistry">طب الأسنان</option>
                        <option value="anesthesia">تخدير وإنعاش</option>
                        <option value="pharmacy">الصيدلة الدوائية</option>
                        <option value="labs">المختبرات الطبية</option>
                        <option value="nursing">التمريض</option>
                        <option value="midwifery">القبالة</option>
                        <option value="admission" class="bg-orange-100 text-orange-800 font-black">نماذج اختبارات القبول</option>
                    </select>
                </div>

                <div id="dynamicFields" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-right">
                    <div>
                        <label class="block text-xs font-black mb-2 mr-2 dark:text-gray-300 text-emerald-700 uppercase tracking-wide">المستوى الدراسي</label>
                        <select name="level" id="levelSelect" onchange="handleLevelChange()"
                                class="w-full bg-gray-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 rounded-2xl py-3 px-3 dark:text-white text-sm font-bold transition-all outline-none cursor-pointer">
                            </select>
                    </div>

                    <div id="termContainer">
                        <label class="block text-xs font-black mb-2 mr-2 dark:text-gray-300 text-emerald-700 uppercase tracking-wide">الفصل الدراسي (الترم)</label>
                        <select name="term" id="termSelect"
                                class="w-full bg-gray-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 rounded-2xl py-3 px-3 dark:text-white text-sm font-bold transition-all outline-none cursor-pointer">
                            <option value="1">الترم الأول</option>
                            <option value="2">الترم الثاني</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-black mb-2 mr-2 dark:text-gray-300 text-emerald-700 uppercase tracking-wide">نوع المحتوى</label>
                        <select name="type" id="typeSelect"
                                class="w-full bg-gray-50 dark:bg-slate-800 border-2 border-transparent focus:border-emerald-500 rounded-2xl py-3 px-3 dark:text-white text-sm font-bold transition-all outline-none cursor-pointer">
                            <option value="theoretical">نظري (Lectures)</option>
                            <option value="practical">عملي (Practical)</option>
                            <option value="exams">نماذج اختبارات</option>
                            <option value="references">مراجع وكتب</option>
                        </select>
                    </div>
                </div>

                <div class="bg-emerald-50/50 dark:bg-emerald-900/10 p-4 rounded-2xl border border-emerald-100 dark:border-emerald-800/30 text-right">
                    <label class="block text-xs font-black mb-2 mr-1 dark:text-emerald-400 text-emerald-800 flex items-center">
                        <i class="fas fa-user-edit ml-2"></i> اسم الشخص الرافع (اختياري)
                    </label>
                    <input type="text" name="uploader_name" placeholder="اتركه فارغاً ليتم الرفع باسمك الافتراضي" 
                           class="w-full bg-white dark:bg-slate-900 border-2 border-transparent focus:border-emerald-500 rounded-xl py-3 px-4 dark:text-white text-sm transition-all outline-none">
                </div>

                <div class="relative group">
                    <input type="file" name="files[]" id="fileInput" required multiple onchange="displayFile()"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div id="dropZone" class="w-full border-2 border-dashed border-emerald-200 dark:border-slate-700 rounded-[2rem] py-8 px-6 text-center transition-all group-hover:bg-emerald-50/50 group-hover:border-emerald-400 dark:group-hover:bg-slate-800/50">
                        <i id="fileIcon" class="fas fa-cloud-upload text-3xl text-emerald-600 mb-3 group-hover:scale-110 transition-transform"></i>
                        <p id="fileName" class="text-sm text-gray-500 dark:text-gray-400 font-bold">اسحب الملفات هنا أو انقر للاختيار</p>
                        <p class="text-[10px] text-gray-400 mt-2 uppercase">PDF, HTML, DOCX, PPTX, JPG (يمكنك اختيار عدة ملفات)</p>
                    </div>
                </div>

                <button type="submit" x-bind:disabled="uploading" 
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-black py-4 rounded-[1.5rem] shadow-xl shadow-emerald-700/20 transition-all transform active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed">
                    <span x-show="!uploading" class="flex items-center justify-center">
                        <i class="fas fa-paper-plane ml-2"></i> رفع الملفات للمكتبة
                    </span>
                    <span x-show="uploading" x-cloak class="flex items-center justify-center">
                        <i class="fas fa-circle-notch fa-spin ml-2"></i> جاري الرفع...
                    </span>
                </button>
            </form>
        </div>

        <section class="mt-12 mb-12" x-data="{ expandedFolder: null }">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-black text-emerald-900 dark:text-white flex items-center">
            <i class="fas fa-folder-tree ml-3 text-emerald-600 text-2xl"></i>
            @if(auth()->user()->role === 'admin') 
                إدارة المجلدات والملفات (التحكم الكامل) 
            @else 
                أرشيف ملفاتي المرفوعة 
            @endif
        </h2>
        @if(auth()->user()->role === 'admin')
            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">Admin Mode</span>
        @endif
    </div>

    <div class="space-y-6">
        @php
            // تجميع الملفات للأدمن حسب المادة
            $displayData = (auth()->user()->role === 'admin') 
                ? $myBooks->groupBy('subject_id') 
                : $myBooks;
        @endphp

        @if(auth()->user()->role === 'admin')
            {{-- ================= عرض الأدمن (نظام المجلدات الذكية) ================= --}}
            @forelse($displayData as $subjectId => $books)
                @php 
                    $subject = $books->first()->subject; 
                    $folderId = 'folder_' . $subjectId;
                @endphp
                <div class="glass-card rounded-[2.5rem] border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden transition-all" 
                     :class="expandedFolder === '{{ $folderId }}' ? 'ring-2 ring-emerald-500 shadow-xl' : ''">
                    
                    {{-- رأس المجلد --}}
                    <div class="p-6 bg-white dark:bg-slate-900 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4 w-full cursor-pointer" @click="expandedFolder = (expandedFolder === '{{ $folderId }}' ? null : '{{ $folderId }}')">
                            <div class="w-14 h-14 bg-emerald-600 rounded-[1.2rem] flex items-center justify-center text-white shadow-lg">
                                <i class="fas fa-folder-open text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="font-black text-emerald-900 dark:text-white text-lg leading-tight">{{ $subject->name ?? 'مادة غير معروفة' }}</h3>
                                {{-- المسار الكامل للمجلد --}}
                                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase flex flex-wrap gap-1">
                                    <span class="text-emerald-600">{{ $subject->department ?? 'عام' }}</span> 
                                    <i class="fas fa-chevron-left text-[8px] self-center"></i> 
                                    <span>مستوى {{ $subject->level ?? '0' }}</span>
                                    <i class="fas fa-chevron-left text-[8px] self-center"></i> 
                                    <span>ترم {{ $subject->term ?? '0' }}</span>
                                    <i class="fas fa-chevron-left text-[8px] self-center"></i> 
                                    <span class="text-blue-500">{{ $books->count() }} ملف</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            {{-- زر حذف المجلد بالكامل --}}
                            <form action="{{ route('subjects.destroy', $subjectId) }}" method="POST" onsubmit="return confirm('⚠️ تحذير: سيتم حذف المادة وكل الملفات المرتبطة بها نهائياً!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white p-3 rounded-2xl transition-all shadow-sm">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                            <button @click="expandedFolder = (expandedFolder === '{{ $folderId }}' ? null : '{{ $folderId }}')" 
                                    class="bg-gray-50 dark:bg-slate-800 p-3 rounded-2xl transition-all">
                                <i class="fas" :class="expandedFolder === '{{ $folderId }}' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                        </div>
                    </div>

                    {{-- قائمة الملفات التفصيلية --}}
                    <div x-show="expandedFolder === '{{ $folderId }}'" x-collapse x-cloak class="border-t border-gray-50 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-950/40 p-5 space-y-4">
                        @foreach($books as $book)
                            <div class="bg-white dark:bg-slate-900 rounded-3xl p-4 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row gap-4 items-center">
                                {{-- أيقونة ونوع الملف --}}
                                <div class="w-12 h-12 bg-gray-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center shrink-0">
                                    @if(str_contains($book->file_type, 'exams')) <i class="fas fa-file-signature text-orange-500"></i>
                                    @elseif(str_contains($book->file_type, 'practical')) <i class="fas fa-microscope text-blue-500"></i>
                                    @else <i class="fas fa-file-lines text-emerald-500"></i> @endif
                                </div>

                                {{-- تفاصيل الملف والرافع --}}
                                <div class="flex-1 text-right w-full">
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <h4 class="font-bold text-sm text-gray-800 dark:text-gray-200">{{ $book->title }}</h4>
                                        <span class="text-[9px] bg-gray-100 dark:bg-slate-800 px-2 py-0.5 rounded-full font-bold uppercase">{{ $book->file_type }}</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3 text-[10px] text-gray-400 font-bold">
                                        <span class="flex items-center gap-1"><i class="fas fa-user-circle text-emerald-500"></i> {{ $book->uploader_name ?? ($book->user->name ?? 'غير معروف') }}</span>
                                        <span class="flex items-center gap-1"><i class="fas fa-envelope-open"></i> {{ $book->user->email ?? 'no-email' }}</span>
                                        <span class="flex items-center gap-1"><i class="fas fa-clock"></i> {{ $book->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                {{-- أزرار التحكم في الملف --}}
                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition" title="مشاهدة"><i class="fas fa-eye"></i></a>
                                    <a href="{{ asset('storage/' . $book->file_path) }}" download class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-xl transition" title="تحميل"><i class="fas fa-download"></i></a>
                                    
                                    {{-- زر تعديل (يفتح مودال أو صفحة أخرى حسب نظامك) --}}
                                    <button class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition" title="تعديل"><i class="fas fa-edit"></i></button>

                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('حذف هذا الملف؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition" title="حذف"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white/30 rounded-[3rem] border-2 border-dashed border-gray-300">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <p class="font-black text-gray-400">لا توجد أي بيانات مرفوعة حالياً</p>
                </div>
            @endforelse

        @else
            {{-- ================= عرض الدكتور / المندوب (الملفات الفردية) ================= --}}
            {{-- (نفس الكود السابق مع تجميل بسيط) --}}
            @foreach($myBooks as $book)
                 <div class="glass-card rounded-[2rem] p-5 border border-white/50 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
                            <i class="fas fa-file-pdf text-xl"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="font-black text-sm text-emerald-900 dark:text-white">{{ $book->title }}</h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $book->subject->name ?? '-' }} | {{ $book->file_type }}</p>
                        </div>
                    </div>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('حذف؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 p-2 hover:bg-red-50 rounded-xl transition"><i class="fas fa-trash-alt"></i></button>
                    </form>
                 </div>
            @endforeach
        @endif
    </div>
</section>
    </main>

    <script>
        function updateUI() {
            const dept = document.getElementById('deptSelect').value;
            const dynamicFields = document.getElementById('dynamicFields');
            const levelSelect = document.getElementById('levelSelect');
            const termSelect = document.getElementById('termSelect');
            const typeSelect = document.getElementById('typeSelect');
            const subjectInput = document.getElementById('subjectInput');

            if (dept === 'admission') {
                dynamicFields.classList.add('hidden');
                subjectInput.value = "نماذج القبول العامة";
                levelSelect.innerHTML = `<option value="0" selected>0</option>`;
                termSelect.innerHTML = `<option value="0" selected>0</option>`;
                typeSelect.innerHTML = `<option value="exams" selected>exams</option>`;
            } else {
                dynamicFields.classList.remove('hidden');
                dynamicFields.classList.add('grid');
                if(subjectInput.value === "نماذج القبول العامة") subjectInput.value = "";

                let maxLevel = (['medicine', 'anesthesia', 'dentistry', 'pharmacy'].includes(dept)) ? 5 : 4;
                let hasInternship = (dept !== 'pharmacy');

                let options = '';
                for (let i = 1; i <= maxLevel; i++) {
                    options += `<option value="${i}">المستوى ${i}</option>`;
                }
                if (hasInternship) {
                    options += `<option value="internship" class="bg-emerald-100 text-emerald-800 font-bold">سنة الامتياز (Internship)</option>`;
                }
                levelSelect.innerHTML = options;
                handleLevelChange();
            }
        }

        function handleLevelChange() {
            const level = document.getElementById('levelSelect').value;
            const termContainer = document.getElementById('termContainer');
            const termSelect = document.getElementById('termSelect');
            const typeSelect = document.getElementById('typeSelect');

            if (level === 'internship') {
                termContainer.style.opacity = '0.3';
                termContainer.style.pointerEvents = 'none';
                termSelect.innerHTML = `<option value="0" selected>عام / امتياز</option>`;
                typeSelect.innerHTML = `
                    <option value="theoretical">نظري (Lectures)</option>
                    <option value="practical">عملي (Practical)</option>
                    <option value="references">مراجع وكتب</option>
                `;
            } else {
                termContainer.style.opacity = '1';
                termContainer.style.pointerEvents = 'auto';
                termSelect.innerHTML = `
                    <option value="1">الترم الأول</option>
                    <option value="2">الترم الثاني</option>
                `;
                typeSelect.innerHTML = `
                    <option value="theoretical">نظري (Lectures)</option>
                    <option value="practical">عملي (Practical)</option>
                    <option value="exams">نماذج اختبارات</option>
                    <option value="references">مراجع وكتب</option>
                `;
            }
        }

        function displayFile() {
            const input = document.getElementById('fileInput');
            const fileName = document.getElementById('fileName');
            const dropZone = document.getElementById('dropZone');
            const icon = document.getElementById('fileIcon');

            if (input.files.length > 0) {
                if (input.files.length === 1) {
                    fileName.innerText = "المختار: " + input.files[0].name;
                } else {
                    fileName.innerText = "تم اختيار " + input.files.length + " ملفات";
                }
                fileName.className = "text-emerald-600 font-black italic text-sm";
                dropZone.classList.add('bg-emerald-50', 'border-emerald-500');
                icon.className = "fas fa-file-circle-check text-3xl text-emerald-600 mb-3";
            }
        }

        function darkModeLogic() {
            return { 
                isDark: localStorage.getItem('dark_mode') === 'true',
                toggleDark() {
                    this.isDark = !this.isDark;
                    localStorage.setItem('dark_mode', this.isDark);
                }
            }
        }
        
        window.onload = updateUI;
    </script>
</body>
</html>