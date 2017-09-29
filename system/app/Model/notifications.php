<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    protected $table = "kuchingi_notification";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'action_user', 'action_type', 'content', 'report_id'];
}
