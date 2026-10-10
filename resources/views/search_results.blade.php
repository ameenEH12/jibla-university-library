<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ isDark: localStorage.getItem('dark_mode') === 'true' }" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتائج البحث | جامعة جبلة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { 'primary-dark': '#12372A', 'emerald-900': '#064e3b' } } }
        }
    </script>
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .dark .glass-card { background: rgba(15, 23, 42, 0.9); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f4f7f6] dark:bg-slate-950 min-h-screen pb-12 transition-colors duration-300 text-right">

    <nav class="max-w-6xl mx-auto p-6 flex justify-between items-center">
        <a href="{{ url('/') }}" class="bg-emerald-700 text-white px-5 py-2 rounded-2xl shadow-lg hover:bg-emerald-800 transition-all font-bold">
            <i class="fas fa-arrow-right ml-2"></i> العودة للرئيسية
        </a>
        <h2 class="text-xl font-black dark:text-white text-emerald-900">نتائج البحث</h2>
    </nav>

    <main class="max-w-4xl mx-auto px-4">
        <div class="glass-card p-6 rounded-[2.5rem] shadow-2xl border border-white/20 dark:border-slate-800">
            
            <div class="mb-8 border-b dark:border-slate-700 pb-4">
                <p class="text-gray-500 dark:text-gray-400 font-bold">
                    لقد بحثت عن: <span class="text-emerald-600 dark:text-emerald-400">"{{ $query }}"</span>
                    <span class="mr-4 text-xs bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 px-3 py-1 rounded-full">
                         عثرنا على ({{ $books->count() }}) نتيجة
                    </span>
                </p>
            </div>

            @if($books->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-500">نعتذر، لم نجد أي ملفات تطابق بحثك</h3>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($books as $book)
                        <div x-data="{ showEdit: false }" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-800/50 rounded-2xl border border-transparent hover:border-emerald-500 transition-all group">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl flex items-center justify-center text-xl ml-4">
                                    <i class="fas {{ $book->file_type == 'theoretical' ? 'fa-book' : ($book->file_type == 'practical' ? 'fa-flask' : 'fa-file-signature') }}"></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-sm dark:text-white text-gray-800 group-hover:text-emerald-700 transition-colors">
                                        {{ $book->title }}
                                    </h4>
                                    <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                                        <span class="text-[10px] font-bold text-gray-500 flex items-center">
                                            <i class="fas fa-layer-group ml-1 text-emerald-600"></i> 
                                            {{ $book->subject->name ?? 'مادة غير محددة' }}
                                        </span>
                                        <span class="text-[10px] font-bold text-gray-500 flex items-center">
                                            <i class="fas fa-user-md ml-1 text-emerald-600"></i> {{ $book->user_name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank" class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg"><i class="fas fa-eye"></i></a>
                                <a href="{{ asset('storage/' . $book->file_path) }}" download class="p-2 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg"><i class="fas fa-download"></i></a>

                                @auth
                                    @if(Auth::user()->isAdmin() || $book->user_id === Auth::id())
                                        <button @click="showEdit = true" class="p-2 text-orange-500 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded-lg">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('حذف نهائي؟')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg"><i class="fas fa-trash"></i></button>
                                        </form>

                                        <template x-if="showEdit">
                                            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                                <div @click.away="showEdit = false" class="bg-white dark:bg-slate-900 w-full max-w-md rounded-3xl p-6 shadow-2xl">
                                                    <h3 class="text-lg font-bold mb-4 dark:text-white">تعديل اسم الملف</h3>
                                                    <form action="{{ route('books.update', $book->id) }}" method="POST">
                                                        @csrf
                                                        <input type="text" name="title" value="{{ $book->title }}" class="w-full p-3 rounded-xl border dark:bg-slate-800 dark:border-slate-700 dark:text-white mb-4 focus:ring-2 focus:ring-emerald-500 outline-none">
                                                        <div class="flex gap-2">
                                                            <button type="submit" class="flex-1 bg-emerald-600 text-white py-2 rounded-xl font-bold">حفظ التغييرات</button>
                                                            <button type="button" @click="showEdit = false" class="flex-1 bg-gray-100 dark:bg-slate-800 dark:text-gray-300 py-2 rounded-xl">إلغاء</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </template>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</body>
</html>