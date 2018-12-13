<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinhasCompras extends Model
{
    protected $table ='linhas_compras';
    public $primaryKey ='Id';
    public $timestamps= false;
    public $incrementing = false;
}
