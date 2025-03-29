<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'classroom_id', 'gender', 'ambition', 'behaviour'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function performances()
    {
        return $this->hasMany(Performance::class, 'student_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
}
