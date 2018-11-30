<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $table ='invoices';
    public $primaryKey ='InvoiceNo';
    public $timestamps= false;
    public $incrementing = false;
}
