<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class report_handler extends Model
{
    protected $table = "report_handler";
    protected $primaryKey = "id";
    protected $fillable = ['type_id', 'report_id', 'reported'];

    public function type(){
    	return $this->hasOne(report_types::class, 'id', 'type_id');
    }

    public function report(){
    	return $this->hasOne(report_posts::class, 'id', 'report_id');
    }
}
