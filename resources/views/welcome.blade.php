<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="darkModeLogic()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جامعة جبلة للعلوم الطبية | المكتبة الرقمية</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'primary-dark': '#12372A',
                        'primary-mid': '#436850',
                        'accent-gold': '#AD8B3A',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Tajawal', sans-serif; transition: all 0.3s; }
        .hero-section {
            background: linear-gradient(180deg, #12372A 0%, #436850 100%);
            border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;
        }
        .dark .hero-section { background: linear-gradient(180deg, #051610 0%, #12372A 100%); }
        .dept-card { transition: all 0.3s ease; cursor: pointer; }
        .dept-card:hover { transform: translateY(-8px); border-color: #AD8B3A; }
        ::-webkit-scrollbar { width: 0px; background: transparent; }
    </style>
</head>
<body class="bg-[#f4f7f6] dark:bg-slate-950 text-primary-dark dark:text-gray-100 pb-32">

<header class="hero-section text-white pt-6 pb-20 px-6 shadow-2xl">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-start mb-8">
            <button @click="toggleDark" class="w-10 h-10 bg-white/10 rounded-full backdrop-blur-md flex items-center justify-center border border-white/10 hover:bg-white/20 transition">
                <i :class="isDark ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-white'"></i>
            </button>
            
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-white rounded-full p-2 shadow-xl mb-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <h1 class="text-lg font-black leading-none text-center">جامعة جبلة للعلوم الطبية</h1>
                <p class="text-[9px] opacity-70 mt-1 font-bold uppercase tracking-widest">المكتبة الإلكترونية المركزية</p>
            </div>

            <div class="flex flex-col gap-2">
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/30 hover:bg-white/30 transition">
                            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" class="w-6 h-6 rounded-full border border-white">
                            <span class="text-[10px] font-bold text-white">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <i class="fas fa-chevron-down text-[8px] text-white transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-32 bg-white dark:bg-slate-900 rounded-xl shadow-2xl border border-gray-100 dark:border-slate-800 z-50 overflow-hidden text-right">
                            <a href="/profile" class="block px-4 py-2 text-[10px] font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-800 border-b dark:border-slate-800">
                                <i class="fas fa-user-circle ml-2 text-emerald-600"></i> ملفي
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-right px-4 py-2 text-[10px] font-bold text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                    <i class="fas fa-sign-out-alt ml-2"></i> خروج
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/auth/google" class="flex items-center gap-2 bg-white text-gray-800 px-3 py-1.5 rounded-xl text-[10px] font-black shadow-lg hover:scale-105 transition">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-3 h-3">
                        <span>دخول الطلاب</span>
                    </a>
                    <a href="/login" class="text-center border border-white/30 bg-white/5 backdrop-blur-sm text-white px-3 py-1 rounded-xl text-[12px] font-bold hover:bg-white/10 transition">
                        دخول الكادر 
                    </a>
                @endauth
            </div>
        </div>

        <div class="relative group max-w-md mx-auto" x-data="{ q: '' }">
            <input type="text" x-model="q" @keyup.enter="if(q) window.location.href='/search?query='+q" placeholder="ابحث عن محاضراتك هنا..." 
                   class="w-full bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl py-4 pr-12 pl-16 text-white placeholder-white/60 outline-none focus:ring-2 focus:ring-accent-gold transition-all text-right" dir="rtl">
            <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-white/50"></i>
            <a :href="'/search?query=' + q" class="absolute left-3 top-1/2 -translate-y-1/2 bg-white text-primary-dark px-4 py-2 rounded-xl text-xs font-bold hover:bg-accent-gold hover:text-white transition-all">بحث</a>
        </div>
    </div>
</header>

<main class="max-w-4xl mx-auto px-6 mt-5">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $departments = [
                ['id' => 'medicine', 'name' => 'طب بشري', 'icon' => 'fa-user-md', 'color' => 'text-blue-600', 'type' => '5+1'],
                ['id' => 'anesthesia', 'name' => 'تخدير', 'icon' => 'fa-syringe', 'color' => 'text-emerald-600', 'type' => '4+1'],
                ['id' => 'dentistry', 'name' => 'طب أسنان', 'icon' => 'fa-tooth', 'color' => 'text-cyan-600', 'type' => '5+1'],
                ['id' => 'pharmacy', 'name' => 'صيدلة', 'icon' => 'fa-pills', 'color' => 'text-purple-600', 'type' => '5'],
                ['id' => 'labs', 'name' => 'مختبرات', 'icon' => 'fa-microscope', 'color' => 'text-amber-600', 'type' => '4+1'],
                ['id' => 'nursing', 'name' => 'تمريض', 'icon' => 'fa-hand-holding-medical', 'color' => 'text-rose-600', 'type' => '4+1'],
                ['id' => 'midwifery', 'name' => 'قبالة', 'icon' => 'fa-baby', 'color' => 'text-pink-600', 'type' => '4+1'],
            ];
        @endphp
        
        @foreach($departments as $dept)
            <a href="{{ url('/dept/' . $dept['id']) }}" class="dept-card bg-white dark:bg-slate-900 p-6 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-slate-800 flex flex-col items-center">
                <div class="w-14 h-14 bg-gray-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center {{ $dept['color'] }} text-2xl mb-3 shadow-inner">
                    <i class="fas {{ $dept['icon'] }}"></i>
                </div>
                <h3 class="font-black text-xs dark:text-white">{{ $dept['name'] }}</h3>
            </a>
        @endforeach
    </div>

    <div class="mt-8">
        <a href="{{ route('admission.direct') }}" class="flex items-center justify-between bg-accent-gold hover:bg-[#96752d] text-white p-6 rounded-[2.5rem] shadow-xl transition transform hover:scale-[1.01]">
            <div>
                <h2 class="text-xl font-black">نماذج اختبارات القبول</h2>
                <p class="text-[10px] opacity-90 font-bold">استعد لاختبارات المفاضلة مع نماذج السنوات السابقة</p>
            </div>
            <div class="text-3xl opacity-50">
                <i class="fas fa-file-signature"></i>
            </div>
        </a>
    </div>

    <footer class="mt-20 border-t border-gray-200 dark:border-slate-800 pt-10 pb-6 text-center">
        <div class="flex justify-center gap-4 mb-6">
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-sky-500 hover:bg-sky-100 dark:hover:bg-sky-950 transition">
                <i class="fab fa-telegram-plane"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-green-500 hover:bg-green-100 dark:hover:bg-green-950 transition">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-950 transition">
                <i class="fab fa-facebook-f"></i>
            </a>            
        </div>
        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">© 2026 جميع الحقوق محفوظة لجامعة جبلة - صُمم بواسطة م. أمين المليكي</p>
    </footer>
</main>

@auth
    @if(auth()->user()->role == 'admin')
        <div class="fixed bottom-24 left-6 z-[90] flex flex-col gap-3">
            <button onclick="document.getElementById('deleteDoctorModal').classList.remove('hidden')" 
                    class="bg-red-600 hover:bg-red-700 text-white w-12 h-12 rounded-2xl shadow-xl flex items-center justify-center transition-all transform hover:scale-110">
                <i class="fas fa-user-slash text-lg"></i>
            </button>
            <button onclick="document.getElementById('editDoctorModal').classList.remove('hidden')" 
                    class="bg-blue-600 hover:bg-blue-700 text-white w-12 h-12 rounded-2xl shadow-xl flex items-center justify-center transition-all transform hover:scale-110">
                <i class="fas fa-user-edit text-lg"></i>
            </button>
            <button onclick="document.getElementById('addDoctorModal').classList.remove('hidden')" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white w-14 h-14 rounded-2xl shadow-2xl flex items-center justify-center transition-all transform hover:scale-110 active:rotate-12">
                <i class="fas fa-user-plus text-xl"></i>
            </button>
        </div>
    @endif
@endauth

<div id="addDoctorModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl relative">
        <button onclick="document.getElementById('addDoctorModal').classList.add('hidden')" class="absolute top-6 left-6 text-gray-400 hover:text-red-500"><i class="fas fa-times-circle text-2xl"></i></button>
        <h3 class="text-xl font-black text-center text-emerald-600 mb-6">إضافة دكتور جديد</h3>
        <form action="{{ route('admin.addDoctor') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="name" placeholder="اسم الدكتور الكامل" required class="w-full p-4 rounded-xl bg-gray-50 dark:bg-slate-800 text-sm font-bold text-right" dir="rtl">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required class="w-full p-4 rounded-xl bg-gray-50 dark:bg-slate-800 text-sm font-bold text-right" dir="rtl">
            <input type="password" name="password" placeholder="كلمة المرور" required class="w-full p-4 rounded-xl bg-gray-50 dark:bg-slate-800 text-sm font-bold text-right" dir="rtl">
            <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 rounded-xl">اعتماد الحساب وتشفيره</button>
        </form>
    </div>
</div>

<div id="editDoctorModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl relative">
        <button onclick="document.getElementById('editDoctorModal').classList.add('hidden')" class="absolute top-6 left-6 text-gray-400 hover:text-red-500"><i class="fas fa-times-circle text-2xl"></i></button>
        <h3 class="text-xl font-black text-center text-blue-600 mb-6">تعديل حسابات الدكاترة</h3>
        <form action="{{ route('admin.editDoctor') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="email" name="email" placeholder="البريد الإلكتروني الحالي للدكتور" required class="w-full p-4 rounded-xl bg-gray-50 dark:bg-slate-800 text-sm font-bold text-right" dir="rtl">
            <input type="text" name="name" placeholder="الاسم الجديد" required class="w-full p-4 rounded-xl bg-gray-50 dark:bg-slate-800 text-sm font-bold text-right" dir="rtl">
            <input type="password" name="password" placeholder="كلمة المرور الجديدة" required class="w-full p-4 rounded-xl bg-gray-50 dark:bg-slate-800 text-sm font-bold text-right" dir="rtl">
            <button type="submit" class="w-full bg-blue-600 text-white font-black py-4 rounded-xl">حفظ وتشفير</button>
        </form>
    </div>
</div>

<div id="deleteDoctorModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl relative">
        <button onclick="document.getElementById('deleteDoctorModal').classList.add('hidden')" class="absolute top-6 left-6 text-gray-400 hover:text-red-500"><i class="fas fa-times-circle text-2xl"></i></button>
        <h3 class="text-xl font-black text-center text-red-600 mb-6">حذف حساب دكتور</h3>
        <form action="{{ route('admin.deleteDoctor') }}" method="POST" class="space-y-4">
            @csrf
            @method('DELETE')
            <input type="email" name="email" placeholder="أدخل البريد الإلكتروني للحذف" required class="w-full p-4 rounded-xl bg-gray-50 dark:bg-slate-800 text-sm font-bold text-right" dir="rtl">
            <p class="text-[10px] text-red-500 font-bold text-center">تحذير: سيتم حذف جميع بيانات الدكتور نهائياً!</p>
            <button type="submit" class="w-full bg-red-600 text-white font-black py-4 rounded-xl">تأكيد الحذف</button>
        </form>
    </div>
</div>

<nav class="fixed bottom-6 left-6 right-6 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl h-16 rounded-[2rem] shadow-2xl flex items-center justify-around px-2 border border-white/20 dark:border-slate-700 z-50">
    <a href="{{ url('/') }}" class="text-emerald-700 dark:text-emerald-400 flex flex-col items-center">
        <i class="fas fa-home text-lg"></i>
        <span class="text-[8px] font-black mt-1">الرئيسية</span>
    </a>
    <button onclick="document.querySelector('input').focus()" class="">
        <i class=""></i>
        <span class="text-[8px] font-black mt-1"></span>
    </button>
    @auth
        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'doctor')
            <div class="relative -mt-12">
                <a href="{{ route('upload.page') }}" class="w-16 h-16 bg-emerald-700 rounded-full flex items-center justify-center text-white text-3xl shadow-lg hover:bg-emerald-800 transition transform hover:rotate-90">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        @else
            <div class="w-14 h-14"></div> 
        @endif
    @else
        <div class="w-14 h-14"></div>
    @endauth
    <a href="{{ route('developer') }}" class="text-gray-400 flex flex-col items-center">
        <i class="fas fa-code text-lg"></i>
        <span class="text-[8px] font-black mt-1">المطور</span>
    </a>
    <a href="/profile" class="text-gray-400 flex flex-col items-center">
        <i class="fas fa-user-circle text-lg"></i>
        <span class="text-[8px] font-black mt-1">حسابي</span>
    </a>
</nav>

<script>
    function darkModeLogic() {
        return {
            isDark: localStorage.getItem('dark_mode') === 'true',
            toggleDark() {
                this.isDark = !this.isDark;
                localStorage.setItem('dark_mode', this.isDark);
            }
        }
    }
</script>
</body>
</html>