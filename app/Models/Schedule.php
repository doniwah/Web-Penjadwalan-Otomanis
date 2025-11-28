<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['course_id', 'lecturer_id', 'room_id', 'timeslot_id', 'class_name'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }
}
