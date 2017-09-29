<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    protected $table = "kuchingi_message";
    protected $primaryKey = "id";
    protected $fillable = ['chat_room_id', 'user_id', 'message'];

    public function user(){
    	return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function room(){
    	return $this->hasOne(chat_rooms::class, 'id', 'chat_room_id');
    }
}
