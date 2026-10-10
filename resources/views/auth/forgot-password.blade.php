<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعادة كلمة المرور | جامعة جبلة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-lg border border-gray-100">
        
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-key text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">نسيت كلمة المرور؟</h2>
            <p class="text-gray-500 mt-2 text-sm">
                لا تقلق! أدخل بريدك الإلكتروني أدناه وسنرسل لك رابطاً آمناً لإعادة تعيين كلمة المرور الخاصة بك.
            </p>
        </div>

        @if (session('status'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl text-center mb-6 text-sm font-bold">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" placeholder="example@jibla.edu.ye" required
                       class="w-full p-4 rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-blue-400 outline-none text-right">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane"></i>
                إرسال رابط إعادة التعيين
            </button>
        </form>

        <div class="mt-10 pt-6 border-t border-gray-100 text-center">
            <h3 class="text-sm font-bold text-gray-600 mb-4">تحتاج مساعدة؟ تواصل معنا</h3>
            <div class="flex justify-center gap-6 text-gray-500">
                <a href="tel:+967XXXXXXXXX" class="hover:text-blue-600 transition">
                    <i class="fas fa-phone-alt ml-2"></i> اتصل بنا
                </a>
                <a href="mailto:support@jibla.edu.ye" class="hover:text-blue-600 transition">
                    <i class="fas fa-envelope ml-2"></i> الدعم الفني
                </a>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-blue-600 font-bold transition">
                <i class="fas fa-arrow-right ml-1"></i> العودة لتسجيل الدخول
            </a>
        </div>
    </div>

</body>
</html>