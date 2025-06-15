<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tor extends Model
{
    use HasFactory;
    protected $table = 'tor_details';

    protected $fillable = [
        'student_id', 'date_of_admission', 'credential', 'transferee', 'date_of_graduation', 'student_picture', 'so_number', 'remarks', 'purpose', 'prepared_by', 'registrar'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
    
}
