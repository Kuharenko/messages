<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleMessage extends Model
{
    protected $fillable = [
        'message_id', 'time'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
