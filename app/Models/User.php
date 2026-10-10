<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * الحقول القابلة للتعبئة (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'role', // تأكد أن هذا الحقل موجود في قاعدة البيانات
    ];

    /**
     * الحقول المخفية عند تحويل المودل إلى Array أو JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحويل أنواع البيانات (Casting)
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // ملاحظة: تم إيقاف 'password' => 'hashed' هنا لتجنب التشفير المزدوج 
            // لأننا نستخدم Hash::make في الكنترولر عند إضافة الدكتور.
        ];
    }

    // --- الدوال الخاصة بصلاحيات المستخدم ---

    /**
     * هل المستخدم مدير نظام (Admin)؟
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * هل المستخدم دكتور (Doctor)؟
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    /**
     * هل المستخدم لديه صلاحية رفع الملفات؟
     * (المدير والدكتور فقط لديهم هذه الصلاحية)
     */
    public function canUpload(): bool
    {
        return in_array($this->role, ['admin', 'doctor']);
    }

    // --- العلاقات (Relationships) ---

    /**
     * علاقة المستخدم مع الملفات/الكتب التي قام برفعها
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}