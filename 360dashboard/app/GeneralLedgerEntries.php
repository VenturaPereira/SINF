<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralLedgerEntries extends Model
{
    protected $table ='general_ledger_entries';
    public $primaryKey ='id';
    public $timestamps= false;
    public $incrementing = false;
}
