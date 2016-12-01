<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //投标表
    protected $table ='bids';
    protected $primaryKey = 'bid';
    public $timestamps = false;
}
