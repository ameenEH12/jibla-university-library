<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'department', 'level', 'term', 'type'];

        public function books() {
            return $this->hasMany(Book::class);
        }

    protected $table = 'subjects'; // أو materials حسب ما تريد اعتماده
}
