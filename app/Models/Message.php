<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'sender_type',
        'receiver_type',
        'message',
        'read'
    ];

    public function sender()
    {
        return $this->morphTo(null, 'sender_type','sender_id');
    }

    public function receiver()
    {
        return $this->morphTo();
    }
}
