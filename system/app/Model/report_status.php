<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class report_status extends Model
{
    protected $table = "kuchingi_report_status";
    protected $primaryKey = "id";
    protected $fillable = ['status_id', 'media_id'];

    public function action(){
    	return $this->hasMany(action::class, 'report_status_id', 'id');
    }

    public function status_name(){
    	return $this->hasOne(status_table::class, 'id', 'status_id');
    }
}
