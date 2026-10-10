<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Book;

class DepartmentController extends Controller
{
    /**
     * عرض المستويات الدراسية بناءً على التخصص
     */
    public function showLevels($dept)
    {
        // تحويل طلبات النماذج العامة
        if ($dept === 'exams' || $dept === 'admission_exams') {
            return redirect()->route('admission.direct');
        }

        $departments = [
            'medicine'    => 'الطب البشري',
            'anesthesia'  => 'طب التخدير والإنعاش',
            'dentistry'   => 'طب وجراحة الفم والأسنان',
            'pharmacy'    => 'الصيدلة الدوائية',
            'labs'        => 'المختبرات الطبية',
            'nursing'     => 'التمريض',
            'midwifery'   => 'القبالة',
        ];

        /**
         * تطبيق شروط م. أمين المليكي:
         * 1. بشري، تخدير، أسنان، صيدلة = 5 مستويات
         * 2. البقية (مختبرات، تمريض، قبالة) = 4 مستويات
         */
        $fiveYearDepts = ['medicine', 'anesthesia', 'dentistry', 'pharmacy'];
        $maxLevels = in_array($dept, $fiveYearDepts) ? 5 : 4;

        $department_name = $departments[$dept] ?? 'قسم غير معروف';

        // تمرير level بقيمة null لمنع خطأ Undefined variable في صفحة المستويات
        return view('levels', [
            'dept'            => $dept,
            'department_name' => $department_name,
            'max_levels'      => $maxLevels,
            'level'           => null 
        ]);
    }

    /**
     * عرض الأترام (الفصول الدراسية)
     */
    public function showTerms($dept, $level)
    {
        if ($level === 'internship') {
            return redirect()->route('dept.types', [$dept, 'internship', '0']);
        }
        return view('terms', compact('dept', 'level'));
    }

    /**
     * عرض أنواع المحتوى (نظري، عملي، مراجع، اختبارات)
     */
    public function showTypes($dept, $level, $term)
    {
        return view('content_types', compact('dept', 'level', 'term'));
    }

    /**
     * عرض الملفات والمواد (الجزء الذي تم إصلاحه)
     */
    public function showFiles($dept, $level, $term, $type)
    {
        // 1. المسميات
        $labels = [
            'theoretical' => 'المحتوى النظري',
            'practical'   => 'المحتوى العملي',
            'references'  => 'الكتب والمراجع',
            'exams'       => 'نماذج الاختبارات',
        ];
        $typeLabel = $labels[$type] ?? 'ملفات القسم';

        // 2. التصحيح هنا: حذفنا ->where('type', $type) من استعلام المواد
        // وجعلنا التصفية تتم داخل جدول الكتب (Books) فقط
        $subjects = Subject::where('department', $dept)
            ->where('level', $level)
            ->where('term', $term)
            ->whereHas('books', function($query) use ($type) {
                $query->where('file_type', $type);
            })
            ->with(['books' => function($query) use ($type) {
                $query->where('file_type', $type);
            }])
            ->get();

        // جلب اسم القسم بالعربي للعرض
        $departments = [
            'medicine'    => 'الطب البشري',
            'anesthesia'  => 'طب التخدير والإنعاش',
            'dentistry'   => 'طب وجراحة الفم والأسنان',
            'pharmacy'    => 'الصيدلة الدوائية',
            'labs'        => 'المختبرات الطبية',
            'nursing'     => 'التمريض',
            'midwifery'   => 'القبالة',
            'admission'   => 'قسم القبول',
        ];
        $deptName = $departments[$dept] ?? $dept;

        return view('files_list', compact('subjects', 'dept', 'level', 'term', 'type', 'typeLabel', 'deptName'));
    }
}