<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\report_types;
use App\Model\locations;

class report_posts extends Model
{
    protected $table = "kuchingi_report";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'type_id', 'location_id', 'status_id','officer_id' , 'title', 'description', 'support', 'affected'];
    public $incrementing = false;

    // public function rows()
    // {
    //     return $this->belongsTo(report_types::class, 'type_ID')->orderBy('order');
    // }

    // public function reportId(){
    // 	return $this->hasOne('App\Model\approve_handler', 'id', 'handler_id');
    // }

    // public function typeId(){
    // 	return $this->belongsTo(report_types::class);
    // }

    // public function approve(){
    //     return $this->hasOne(status_table::class, 'id', 'approve_status');
    // }

    public function location(){
    	return $this->hasOne(locations::class, 'id', 'location_id');
    }

    public function status(){
        return $this->hasOne(status_table::class, 'id', 'status_id');
    }

    public function media(){
        return $this->hasOne(report_media::class, 'report_id');
    }

    public function user(){
        return $this->hasOne(mobile_user::class, 'id', 'user_id');
    }

    public function category(){
        return $this->hasOne(report_types::class, 'id', 'type_id');
    }

    public function unsolve(){
        return $this->hasOne(report_status::class, 'id', 'status_id')->where('status_id', 2);
    }

    public function officer(){
        return $this->hasOne(mobile_user::class, 'id', 'officer_id');
    }

    public function action(){
        return $this->hasMany(action::class, 'report_id')->orderBy('created_at', 'desc');
    }

    public function response(){
        return $this->hasMany(response::class, 'report_id');
    }

    // public function handler(){
    //     return $this->hasOne(approve_handler::class, 'report_id', 'id');
    // }

    // public function category(){
    //     return $this->hasOne(report_types::class, 'id', 'type_ID');
    // }

    // public function autoReport(){
    //     return $this->category()->where('isAutoReport', 1);
    // }
}
