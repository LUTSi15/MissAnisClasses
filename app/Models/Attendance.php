<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'date', 'is_present']; // Fixed fillable columns

    /**
     * Relationship: An attendance record belongs to a student.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
