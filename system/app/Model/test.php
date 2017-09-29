<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class test extends Model
{
    protected $table = "kuchingi_test";
    protected $primaryKey = "id";
    protected $fillable = [];
    public $incrementing = false;
}
