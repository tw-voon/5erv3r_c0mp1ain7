<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activity_handler extends Model
{
    protected $table = "activity_handler";
    protected $primaryKey = "activity_id";
    protected $fillable = ['action_done_by', 'action_done_on', 'report_id', 'action_name'];
}
