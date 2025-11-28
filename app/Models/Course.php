<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['code', 'name', 'sks', 'semester', 'is_lab'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    //
}
