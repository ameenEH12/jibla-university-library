<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Subject; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * عرض صفحة الرفع مع عرض ملفات المستخدم الحالية (أو كل الملفات للأدمن)
     */
    public function create() {
        if (!auth()->user()->canUpload()) {
            return abort(403, 'غير مسموح لك بالرفع');
        }
        
        // تعديل مهم: أضفنا subject لضمان ظهور المسارات (طب، مستوى، ترم) ومنع ظهور "مادة غير معروفة"
        if (auth()->user()->isAdmin()) {
            $myBooks = Book::with(['user', 'subject'])->latest()->get();
        } else {
            $myBooks = Book::with(['user', 'subject'])->where('user_id', auth()->id())->latest()->get();
        }
        
        return view('upload', compact('myBooks')); 
    }

    /**
     * دالة البحث في الكتب والمواد وأسماء الدكاترة
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $books = Book::where('title', 'LIKE', "%{$query}%")
                     ->orWhere('user_name', 'LIKE', "%{$query}%")
                     ->orWhereHas('subject', function($q) use ($query) {
                         $q->where('name', 'LIKE', "%{$query}%");
                     })
                     ->with(['subject', 'user']) 
                     ->get();

        return view('search_results', compact('books', 'query'));
    }

    /**
     * حفظ ملف جديد وربطه بالمادة (إنشاء المادة إذا لم تكن موجودة)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'files'         => 'required|array',
            'files.*'       => 'file|mimes:pdf,doc,html,docx,ppt,pptx,png,jpg,jpeg|max:20480',
            'department'    => 'required',
            'level'         => 'required',
            'term'          => 'required',
            'subject_name'  => 'required|string',
            'type'          => 'required',
            'uploader_name' => 'nullable|string|max:255', 
        ]);

        $finalUploaderName = $request->filled('uploader_name') ? $request->uploader_name : auth()->user()->name;
        $level = $request->level;
        $term = ($level === 'internship' || $request->department === 'admission') ? '0' : $request->term;

        $subject = Subject::firstOrCreate([
            'name'       => $request->subject_name,
            'department' => $request->department,
            'level'      => $level,
            'term'       => $term,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads/books', $fileName, 'public');

                Book::create([
                    'title'      => $request->title,
                    'file_path'  => $path,
                    'file_type'  => $request->type, 
                    'subject_id' => $subject->id,
                    'user_id'    => auth()->id(),
                    'user_name'  => $finalUploaderName,
                ]);
            }
        }

        // --- منطق بناء رسالة النجاح التفصيلية ---
        $depts = [
            'medicine' => 'الطب البشري', 'dentistry' => 'طب الأسنان', 'anesthesia' => 'تخدير وإنعاش',
            'pharmacy' => 'الصيدلة الدوائية', 'labs' => 'المختبرات الطبية', 'nursing' => 'التمريض',
            'midwifery' => 'القبالة', 'admission' => 'نماذج اختبارات القبول'
        ];
        $types = [
            'theoretical' => 'نظري', 'practical' => 'عملي', 
            'exams' => 'نماذج اختبارات', 'references' => 'كتب ومراجع'
        ];

        $deptName = $depts[$request->department] ?? 'القسم المختار';
        $typeName = $types[$request->type] ?? 'المحتوى';

        if ($request->department === 'admission') {
            $msg = "تمت إضافة اختبارات قبول بنجاح.";
        } elseif ($level === 'internship') {
            $msg = "تم الرفع بنجاح إلى قسم ($deptName) - سنة امتياز - فئة ($typeName) - مادة: {$request->subject_name}.";
        } else {
            $msg = "تم الرفع بنجاح إلى قسم ($deptName) - المستوى ($level) - الترم ($request->term) - فئة ($typeName) - مادة: {$request->subject_name}.";
        }

        return back()->with('success', $msg);
    }

    /**
     * دالة مساعدة لتحسين رسائل النجاح
     */
    private function getTypeLabel($type) {
        $labels = [
            'theoretical' => 'المحتوى النظري',
            'practical'   => 'المحتوى العملي',
            'exams'       => 'نماذج الاختبارات',
            'references'  => 'المراجع والكتب',
        ];
        return $labels[$type] ?? 'المكتبة';
    }

    /**
     * تحديث اسم الملف
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        if (Auth::user()->isAdmin() || $book->user_id === Auth::id()) {
            $request->validate(['title' => 'required|string|max:255']);
            $book->update(['title' => $request->title]);
            return back()->with('success', 'تم تحديث الاسم بنجاح');
        }
        return abort(403);
    }

    /**
     * حذف ملف واحد نهائياً (تعديل الـ Parameter لحل خطأ 404)
     */
    public function destroy($id) 
    {
        $book = Book::findOrFail($id);
        if (Auth::user()->isAdmin() || $book->user_id === Auth::id()) {
            if (Storage::disk('public')->exists($book->file_path)) {
                Storage::disk('public')->delete($book->file_path);
            }
            
            $book->delete();
            return back()->with('success', 'تم حذف الملف نهائياً');
        }
        return abort(403);
    }

    /**
     * حذف مادة كاملة بجميع ملفاتها (تعديل الـ Parameter لحل خطأ 404)
     */
    public function destroySubject($id)
    {
        if (Auth::user()->isAdmin()) {
            $subject = Subject::with('books')->findOrFail($id);
            foreach ($subject->books as $book) {
                if (Storage::disk('public')->exists($book->file_path)) {
                    Storage::disk('public')->delete($book->file_path);
                }
                $book->delete();
            }

            $subject->delete(); 
            return back()->with('success', 'تم حذف المادة وجميع ملفاتها بنجاح');
        }
        return abort(403);
    }

    /**
     * عرض نماذج القبول
     */
    public function showAdmissionExams()
    {
        $subjects = Subject::where('department', 'admission')->with('books')->get();

        return view('admission_list', [
            'subjects' => $subjects,
            'dept'     => 'admission',
            'type'     => 'exams',
            'level'    => 'عام',
            'term'     => 'بدون'
        ]);
    }
}