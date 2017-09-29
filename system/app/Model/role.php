<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $table = "kuchingi_roles";
    protected $primaryKey = "id";
    protected $fillable = ['name'];
}
