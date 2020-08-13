<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'message_from', 'message_to', 'message_content','reply_to_unkown',
    ];
}
