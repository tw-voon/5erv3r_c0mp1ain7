<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tip_categories extends Model
{
    protected $table = "kuchingi_tips_category";
    protected $primaryKey = "id";
    protected $fillable = ['name', 'status'];
}
