<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingAssignment extends Model
{
    protected $fillable = ['course_id', 'lecturer_id_1', 'lecturer_id_2', 'class_name', 'prodi', 'semester'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id_1');
    }

    public function lecturer1()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id_1');
    }

    public function lecturer2()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id_2');
    }
}
