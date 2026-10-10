<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index($type, $dept, $level, $term)
    {
        // 1. مسميات الأنواع
        $labels = [
            'theoretical' => 'المحتوى النظري',
            'practical'   => 'المحتوى العملي',
            'references'  => 'الكتب والمراجع',
            'exams'       => 'نماذج الاختبارات',
        ];
        $typeLabel = $labels[$type] ?? 'ملفات القسم';

        // 2. بناء الاستعلام باستخدام 'department' (اسم الحقل في المايجريشن عندك)
        $query = Subject::where('department', $dept);

        // 3. معالجة حالة الامتياز
        if ($level === 'internship') {
            $query->where('level', 'internship');
        } else {
            $query->where('level', $level)
                  ->where('term', $term);
        }

        // 4. جلب المواد التي تحتوي على ملفات من النوع المختار
        $subjects = $query->whereHas('books', function($q) use ($type) {
                $q->where('file_type', $type);
            })
            ->with(['books' => function($q) use ($type) {
                $q->where('file_type', $type);
            }])
            ->get();

        // 5. مسميات الأقسام للـ Breadcrumbs
        $departments = [
            'medicine'   => 'الطب البشري',
            'pharmacy'   => 'الصيدلة الدوائية',
            'anesthesia' => 'طب التخدير والإنعاش',
            'dentistry'  => 'طب وجراحة الفم والأسنان',
            'labs'       => 'المختبرات الطبية',
            'nursing'    => 'التمريض',
            'midwifery'  => 'القبالة',
            'admission'  => 'قسم القبول',
        ];
        $deptName = $departments[$dept] ?? $dept;

        return view('subjects.index', compact('subjects', 'type', 'dept', 'level', 'term', 'typeLabel', 'deptName'));
    }
}