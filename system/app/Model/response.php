<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class response extends Model
{
    protected $table = "kuchingi_response";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'report_id', 'support', 'affected'];
}
