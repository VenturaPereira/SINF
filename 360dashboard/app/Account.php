<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table ='accounts';
    public $primaryKey ='AccountID';
    public $timestamps= false;
    public $incrementing = false;
}
