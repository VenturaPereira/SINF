<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lines extends Model
{
    protected $table ='lines';
    public $primaryKey ='InvoiceNo';
    public $timestamps= false;
    public $incrementing = false;
}
