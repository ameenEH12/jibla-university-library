<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="darkModeLogic()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معلومات المطور | المهندس أمين المليكي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Tajawal', sans-serif; transition: all 0.3s; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
        .dark .glass { background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255,255,255,0.05); }
        .social-btn { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .social-btn:hover { transform: translateY(-3px); filter: brightness(1.1); }
    </style>
</head>
<body class="bg-emerald-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col items-center justify-center p-6">

    <a href="/" class="fixed top-6 right-6 w-10 h-10 glass rounded-full flex items-center justify-center hover:scale-110 transition shadow-lg z-50">
        <i class="fas fa-arrow-right"></i>
    </a>

    <div class="max-w-md w-full glass rounded-[3rem] p-8 shadow-2xl text-center relative overflow-hidden">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative inline-block mb-6">
            <div class="w-32 h-32 rounded-full border-4 border-emerald-500 p-1 shadow-2xl mx-auto overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-800 flex items-center justify-center">
                <span class="text-white text-4xl font-black tracking-tighter">EH12</span>
            </div>
            <div class="absolute bottom-1 right-2 bg-emerald-600 text-white text-xs px-2 py-1 rounded-lg border-2 border-white dark:border-slate-800">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>

        <h1 class="text-2xl font-black mb-1">المهندس: أمين المليكي</h1>
        <p class="text-emerald-600 dark:text-emerald-400 font-bold text-sm mb-4"> Developer</p>
        
        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
            لطلب المشاريع البرمجية أو الاستشارات التقنية، يسعدني تواصلكم عبر المنصات التالية:
        </p>

        

        <div class="grid grid-cols-2 gap-3 mb-4">
            <a href="https://wa.me/xxxxxxxxxxx" target="_blank" class="social-btn flex items-center justify-center gap-2 bg-[#25D366] text-white py-3 rounded-2xl shadow-lg">
                <i class="fab fa-whatsapp"></i>
                <span class="text-xs font-bold">WhatsApp</span>
            </a>

            <a href="https://t.me/xxxxxxxx" target="_blank" class="social-btn flex items-center justify-center gap-2 bg-[#229ED9] text-white py-3 rounded-2xl shadow-lg">
                <i class="fab fa-telegram-plane"></i>
                <span class="text-xs font-bold">Telegram</span>
            </a>

            <a href="https://instagram.com/xxxxxxxx" target="_blank" class="social-btn flex items-center justify-center gap-2 bg-[#E1306C] text-white py-3 rounded-2xl shadow-lg">
                <i class="fab fa-instagram"></i>
                <span class="text-xs font-bold">Instagram</span>
            </a>

            <a href="https://facebook.com/xxxxxxxx" target="_blank" class="social-btn flex items-center justify-center gap-2 bg-[#1877F2] text-white py-3 rounded-2xl shadow-lg">
                <i class="fab fa-facebook-f"></i>
                <span class="text-xs font-bold">Facebook</span>
            </a>
        </div>

        <a href="mailto:example@gmail.com?subject=طلب مشروع جديد&body=تحية طيبة مهندس أمين، أود الاستفسار عن إمكانية العمل على مشروع..." class="social-btn flex items-center justify-center gap-2 bg-slate-900 dark:bg-emerald-600 text-white py-3 rounded-2xl shadow-lg w-full">
            <i class="fas fa-envelope"></i>
            <span class="txt-xs font-bold">إرسال طلب مشروع (Email)</span>
        </a>
    </div>

    <p class="mt-8 text-[10px] text-slate-400 font-bold uppercase tracking-widest flex items-center gap-2">
        <span>Built with Passion & Excellence</span>
        <span class="w-1 h-1 bg-emerald-500 rounded-full"></span>
        <span>EH12</span>
    </p>

    <script>
        function darkModeLogic() {
            return {
                isDark: localStorage.getItem('darkMode') === 'true',
            }
        }
    </script>
</body>
</html>