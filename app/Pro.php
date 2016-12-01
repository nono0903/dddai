<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pro extends Model
{
    //project表的model类
    protected $table = 'projects';
    protected $primaryKey = 'pid';
    public $timestamps = false;
}
