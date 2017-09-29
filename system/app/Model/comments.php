<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    protected $table = "kuchingi_comment";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'report_id', 'message'];

    public function user(){
    	return $this->hasOne(mobile_user::class, 'id', 'user_id');
    }
}
