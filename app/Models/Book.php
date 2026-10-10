<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'subject_id', 
        'user_id', 
        'title', 
        'file_path', 
        'file_type',
        'user_name' // تأكد من وجوده هنا
    ];
    public function subject()
    {
        // تأكد أنها تنتمي لـ Subject وليس Material
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
