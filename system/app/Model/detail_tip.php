<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class detail_tip extends Model
{
    protected $table = "kuchingi_category_details";
    protected $primaryKey = "id";
    protected $fillable = ['category_id', 'title', 'message', 'status'];
}
