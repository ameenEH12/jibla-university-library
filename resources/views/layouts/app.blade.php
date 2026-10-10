<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="darkModeLogic" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مكتبة جامعة جبلة - النظام الذكي</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        emerald: { 700: '#047857', 800: '#065f46', 900: '#064e3b' }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap');
        body { font-family: 'Tajawal', sans-serif; transition: background-color 0.3s, color 0.3s; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #059669; border-radius: 10px; }
    </style>
</head>

<body class="bg-gray-50 dark:bg-slate-950 text-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-gray-200 dark:border-slate-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex items-center space-x-3 space-x-reverse cursor-pointer" onclick="window.location='/'">
                    <div class="p-2.5 bg-emerald-600 rounded-2xl shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-microscope text-white text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-xl font-black text-emerald-700 dark:text-emerald-400 block leading-none">جامعة جبلة</span>
                        <span class="text-[10px] text-gray-500 dark:text-gray-400 font-bold uppercase tracking-widest">Medical Digital Library</span>
                    </div>
                </div>

                <div class="flex items-center space-x-4 space-x-reverse">
                    <button @click="toggleDarkMode" class="p-3 rounded-xl bg-gray-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all">
                        <i x-show="!isDark" class="fas fa-moon text-xl text-slate-700"></i>
                        <i x-show="isDark" class="fas fa-sun text-xl text-yellow-400"></i>
                    </button>

                    @guest
                        <a href="/login" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-2.5 rounded-xl font-bold transition shadow-lg shadow-emerald-500/20">دخول</a>
                    @else
                        <div class="flex items-center space-x-3 space-x-reverse border-r border-gray-200 dark:border-slate-700 pr-4">
                            <div class="text-right leading-tight hidden md:block">
                                <p class="text-sm font-black">{{ auth()->user()->name }}</p>
                                <span class="inline-block px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-md uppercase">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center border-2 border-emerald-500/20">
                                <i class="fas fa-user-md text-emerald-600 dark:text-emerald-400"></i>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-slate-900 border-t border-gray-200 dark:border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex justify-center space-x-8 space-x-reverse mb-8">
                <a href="#" class="text-gray-400 hover:text-emerald-500 transition-colors text-xl"><i class="fab fa-whatsapp"></i></a>
                <a href="#" class="text-gray-400 hover:text-emerald-500 transition-colors text-xl"><i class="fab fa-telegram-plane"></i></a>
            </div>
            <p class="text-gray-400 dark:text-gray-500 text-[11px] font-bold tracking-[0.2em] uppercase">
                © 2026 مكتبة جامعة جبلة للطب والعلوم الصحية - صمم بواسطة م. أمين المليكي
            </p>

        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('darkModeLogic', () => ({
                isDark: localStorage.getItem('dark_mode') === 'true',
                init() {
                    this.$watch('isDark', val => localStorage.setItem('dark_mode', val))
                },
                toggleDarkMode() {
                    this.isDark = !this.isDark;
                }
            }))
        })
    </script>
</body>
</html>