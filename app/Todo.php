<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Todo extends Model
{
    protected $fillable = [
        'user_id', 'text'
    ];

    protected $casts = [
        'completed_on' => 'datetime',
        'is_completed' => 'boolean'
    ];

    public function markComplete()
    {
        $this->is_completed = true;
        $this->completed_on = new DateTime();
        $this->save();
    }

    public function markIncomplete()
    {
        $this->is_completed = false;
        $this->completed_on = null;
        $this->save();
    }
}
