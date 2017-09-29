<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class chat_handler extends Model
{
    protected $table = "kuchingi_chat_handler";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'room_id'];

    public function chatroom(){
    	return $this->hasOne(chat_rooms::class, 'id', 'room_id');
    }
}
