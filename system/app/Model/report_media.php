<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class report_media extends Model
{
    protected $table = "kuchingi_report_media";
    protected $primaryKey = "id";
    protected $fillable = ['report_id','media_type', 'link'];
}
