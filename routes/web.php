<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SubjectController;

/*
|--------------------------------------------------------------------------
| Web Routes - بوابة جامعة جبلة للعلوم الطبية
|--------------------------------------------------------------------------
*/

// --- 1. الصفحات العامة الأساسية ---
Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/developer', function () { return view('developer'); })->name('developer');

// مسار استقبال طلبات استعادة كلمة المرور
Route::post('/password-request', [AuthController::class, 'handlePasswordRequest'])->name('password.request.send');

// --- 2. نظام تسجيل الدخول (Google & Manual) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/manual', [AuthController::class, 'manualLogin'])->name('login.manual');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');


// --- 3. مسارات عرض المحتوى للطلاب (التنقل بين الأقسام) ---
Route::get('/subject/{subject_id}/files/{type}', [StudentController::class, 'showFiles'])->name('student.files');
Route::get('/admission-exams-direct', [BookController::class, 'showAdmissionExams'])->name('admission.direct');
Route::get('/dept/{dept}', [DepartmentController::class, 'showLevels'])->name('dept.levels');
Route::get('/dept/{dept}/level/{level}', [DepartmentController::class, 'showTerms'])->name('dept.terms');
Route::get('/dept/{dept}/level/{level}/term/{term}', [DepartmentController::class, 'showTypes'])->name('dept.types');
Route::get('/dept/{dept}/level/{level}/term/{term}/type/{type}', [DepartmentController::class, 'showFiles'])->name('dept.files');


// --- 4. مسارات الإدارة والرفع (محمية بـ Auth) ---
Route::middleware(['auth'])->group(function () {
    
    // [أ] إدارة الدكاترة
    Route::post('/admin/add-doctor', [UserController::class, 'addDoctor'])->name('admin.addDoctor');
    Route::put('/admin/edit-doctor', [AdminController::class, 'editDoctor'])->name('admin.editDoctor');
    Route::delete('/admin/delete-doctor', [AdminController::class, 'deleteDoctor'])->name('admin.deleteDoctor');

    // [ب] نظام الرفع (تم التعديل هنا لإنهاء مشكلة MethodNotAllowed)
    // مسار عرض الصفحة (GET)
    Route::get('/upload-file', [BookController::class, 'create'])->name('upload.page'); 
    
    // مسار استقبال الرفع (POST) - جعلنا الاسم مطابق لما في الـ View
    Route::post('/upload-file', [BookController::class, 'store'])->name('books.store'); 

    // [ج] إدارة الملفات (حذف وتحديث)
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    
    // [د] إدارة المواد
    Route::delete('/subjects/{subject}', [BookController::class, 'destroySubject'])->name('subjects.destroy');

    // [هـ] الملف الشخصي (Profile)
    Route::get('/profile', function () {
        $subjectsCount = \App\Models\Subject::count(); 
        $filesCount = \App\Models\Book::where('user_id', auth()->id())->count();
        return view('profile', compact('subjectsCount', 'filesCount'));
    })->name('profile');

    // مسار القبول داخل الحماية
    Route::get('/admission-exams', [BookController::class, 'showAdmissionExams'])->name('admission.exams');
});

// البحث
Route::get('/search', [BookController::class, 'search'])->name('search');

Route::get('/subjects/{type}/{dept}/{level}/{term}', [SubjectController::class, 'index'])
     ->name('subjects.index');