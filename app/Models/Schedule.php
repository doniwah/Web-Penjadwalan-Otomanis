<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['course_id', 'lecturer_id_1', 'lecturer_id_2', 'room_id', 'timeslot_id', 'class_name', 'teaching_assignment_id'];

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

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function teachingAssignment()
    {
        return $this->belongsTo(TeachingAssignment::class);
    }
}
