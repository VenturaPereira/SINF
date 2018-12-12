<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CabecCompras extends Model
{
    protected $table ='cabec_compras';
    public $primaryKey ='id';
    public $timestamps= false;
    public $incrementing = false;
}
