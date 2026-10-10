<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ role: 'student', showPass: false }" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | جامعة جبلة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        [x-cloak] { display: none !important; }
        ::placeholder { color: #94a3b8 !important; opacity: 1; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 dark:border-slate-800">
        <div class="bg-emerald-700 p-8 text-center text-white relative">
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white rounded-full p-2 shadow-xl mb-4 mx-auto">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <h2 class="text-xl font-black">مرحباً بك في نظام الجامعة</h2>
                <p class="text-xs opacity-70 mt-1">اختر طريقة تسجيل الدخول المناسبة</p>
            </div>
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-10 -mt-10"></div>
        </div>

        <div class="p-8">
            <div class="flex bg-gray-100 dark:bg-slate-800 rounded-2xl p-1 mb-8">
                <button @click="role = 'student'" :class="role === 'student' ? 'bg-white dark:bg-slate-700 shadow-md text-emerald-700' : 'text-gray-500'" class="flex-1 py-2 rounded-xl text-sm font-bold transition-all">الطلاب</button>
                <button @click="role = 'staff'" :class="role === 'staff' ? 'bg-white dark:bg-slate-700 shadow-md text-emerald-700' : 'text-gray-500'" class="flex-1 py-2 rounded-xl text-sm font-bold transition-all">الكادر الأكاديمي</button>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-50 text-red-600 text-xs font-bold shadow-sm border border-red-100">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle ml-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div x-show="role === 'student'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95">
                <p class="text-center text-sm text-gray-500 mb-6 font-bold italic">للوصول السريع، يرجى استخدام بريد الجامعة</p>
                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 py-4 rounded-2xl hover:bg-gray-50 dark:hover:bg-slate-700 transition shadow-sm mb-4 group">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-6 h-6">
                    <span class="font-bold text-gray-700 dark:text-gray-200">الدخول بواسطة جوجل</span>
                </a>
            </div>

            <div x-show="role === 'staff'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-cloak>
                <form action="{{ route('login.manual') }}" method="POST" class="space-y-4" autocomplete="off">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 mr-2">البريد الإلكتروني</label>
                        <input type="email" name="email" 
                               placeholder="يرجى إدخال البريد الإلكتروني" 
                               required 
                               autocomplete="off"
                               class="w-full bg-gray-50 dark:bg-slate-800 border border-transparent focus:border-emerald-500 rounded-2xl px-4 py-4 outline-none text-sm text-gray-700 dark:text-gray-200 transition-all focus:ring-2 focus:ring-emerald-500/20 text-right" dir="rtl">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 mr-2">كلمة المرور</label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" 
                                   name="password" 
                                   placeholder="يرجى إدخال كلمة المرور" 
                                   required 
                                   autocomplete="new-password"
                                   class="w-full bg-gray-50 dark:bg-slate-800 border border-transparent focus:border-emerald-500 rounded-2xl px-4 py-4 outline-none text-sm text-gray-700 dark:text-gray-200 transition-all focus:ring-2 focus:ring-emerald-500/20 text-right" dir="rtl">
                            
                            <button type="button" @click="showPass = !showPass" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition">
                                <i class="fas" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between px-2">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
                            <label for="remember" class="text-[10px] font-bold text-gray-500 italic cursor-pointer">تذكرني</label>
                        </div>
                        
                        <a href="https://wa.me/967780566494?text=السلام عليكم إدارة جامعة جبلة، أرغب في استعادة كلمة المرور الخاصة بحسابي الأكاديمي." 
                           target="_blank" 
                           class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 transition hover:underline">
                            نسيت كلمة المرور؟
                        </a>
                    </div>

                    <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-4 rounded-2xl shadow-lg transition transform active:scale-95 shadow-emerald-200 dark:shadow-none">
                        تسجيل الدخول للنظام
                    </button>
                </form>
            </div>

            <div class="mt-8 text-center border-t border-gray-100 dark:border-slate-800 pt-6">
                <a href="/" class="text-xs font-bold text-gray-400 hover:text-emerald-600 transition">
                    <i class="fas fa-arrow-right ml-1"></i> العودة للرئيسية
                </a>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="fixed bottom-4 right-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-bold shadow-2xl flex items-center gap-2 animate-bounce">
            <i class="fas fa-check-circle text-lg"></i>
            {{ session('status') }}
        </div>
    @endif

</body>
</html>