<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class status_table extends Model
{
    protected $table = "kuchingi_status";
    protected $primaryKey = "id";
    protected $fillable = ['name'];

    public function report_status(){
    	$this->belongsTo(report_status::class, 'status_id', 'id');
    }
}
