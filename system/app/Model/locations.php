<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class locations extends Model
{
    protected $table = "kuchingi_location";
    protected $primaryKey = "id";
    protected $fillable = ['name', 'lat', 'lon'];

    public function location_id(){
    	$this->belongsTo(report_posts::class, 'location_ID', 'id');
    }
}
