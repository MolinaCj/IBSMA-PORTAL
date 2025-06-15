<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormerSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'school_name', 'school_year', 'year', 'semester', 'code', 'title', 'grade', 'credits', 'remarks'
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
