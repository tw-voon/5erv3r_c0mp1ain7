<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class media_type extends Model
{
    protected $table = "kuchingi_media_type";
    protected $primaryKey = "id";
    protected $fillable = ['name'];
}
