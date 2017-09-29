<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class hotline extends Model
{
    
    protected $table = "kuchingi_hotline";
    protected $primaryKey = "id";
    protected $fillable = ['name', 'description', 'number', 'status'];
    
}
