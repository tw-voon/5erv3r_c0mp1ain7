<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class mobile_user extends Model
{
    protected $table = "kuchingi_users";
    protected $primaryKey = "id";
    protected $fillable = ['name', 'email', 'role_id', 'avatar_link'];
    protected $hidden = [
        'password'
    ];

    public function report_news(){
    	$this->belongsTo(report_posts::class, 'user_ID', 'id');
    }

    public function role(){
    	return $this->hasOne(role::class, 'id', 'role_id');
    }
}
