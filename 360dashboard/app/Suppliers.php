<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table ='suppliers';
    public $primaryKey ='SupplierID';
    public $timestamps= false;
    public $incrementing = false;
}
