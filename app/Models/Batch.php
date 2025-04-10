<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'description',
        'thumbnail',
    ];
}
