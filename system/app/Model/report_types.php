<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class report_types extends Model
{
    protected $table = "kuchingi_report_type";
    protected $primaryKey = "id";
    protected $fillable = ['name'];

    public function reporttype(){
    	return $this->belongsTo(report_posts::class, 'type_ID', 'id');
    }

    public function type(){
    	return $this->hasMany(report_posts::class, 'type_ID', 'id');
    }
}
