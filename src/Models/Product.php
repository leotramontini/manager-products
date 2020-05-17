<?php

namespace Manager\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = [
        'name',
        'status_id',
        'image_path'
    ];
}
