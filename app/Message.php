<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'text'
    ];

    public function schedules() {
        return $this->hasMany(ScheduleMessage::class);
    }
}
