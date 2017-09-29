<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class chat_status extends Model
{
    protected $table = "kuchingi_chat_status";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'chat_room_id'];
}
