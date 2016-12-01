<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Att extends Model
{
    //project附表
    protected $table = 'atts';
    protected $primaryKey = 'aid';
    public $timestamps = false;
}
