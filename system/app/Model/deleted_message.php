<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class deleted_message extends Model
{
    protected $table = "kuchingi_deleted_message";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'msg_id'];

    public function user(){
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function message(){
    	return $this->hasOne(message::class, 'id', 'msg_id');
    }
}
