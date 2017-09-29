<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class action extends Model
{
    protected $table = "kuchingi_action";
    protected $primaryKey = "id";
    protected $fillable = ['report_id', 'action_taken', 'media_type', 'link', 'current_status_id'];
}
