<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class approve_handler extends Model
{
    protected $table = "approve_handler";
    protected $primaryKey = "id";
    protected $fillable = ['report_id', 'status_id', 'reason', 'action_taken'];

    public function status(){
    	return $this->hasOne(status_table::class, 'id', 'status_id');
    }

    public function report(){
    	return $this->hasOne(report_posts::class, 'id', 'report_id');
    }

    // public function approve(){
    //     return $this->hasOne(status_table::class, 'id', 'approve_status');
    // }

    // public function location(){
    // 	return $this->hasOne(locations::class, 'id', 'location_ID');
    // }

    // public function mobileuser(){
    //     return $this->hasOne(mobile_user::class, 'id', 'user_ID');
    // }

    // public function handler(){
    //     return $this->hasOne(approve_handler::class, 'report_id', 'id');
    // }
}
