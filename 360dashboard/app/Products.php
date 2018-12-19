<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table ='products';
    public $primaryKey ='ProductNumberCode';
    public $timestamps= false;
    public $incrementing = false;
}
