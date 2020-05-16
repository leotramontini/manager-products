<?php

namespace Manager\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $fillable = [
        'name',
        'alias'
    ];
}
