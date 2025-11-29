<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplacementSchedule extends Model
{
    protected $fillable = [
        'schedule_id',
        'lecturer_id',
        'original_date',
        'replacement_date',
        'original_timeslot_id',
        'replacement_timeslot_id',
        'original_room_id',
        'replacement_room_id',
        'reason',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'original_date' => 'date',
        'replacement_date' => 'date',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function originalTimeslot()
    {
        return $this->belongsTo(Timeslot::class, 'original_timeslot_id');
    }

    public function replacementTimeslot()
    {
        return $this->belongsTo(Timeslot::class, 'replacement_timeslot_id');
    }

    public function originalRoom()
    {
        return $this->belongsTo(Room::class, 'original_room_id');
    }

    public function replacementRoom()
    {
        return $this->belongsTo(Room::class, 'replacement_room_id');
    }
}
