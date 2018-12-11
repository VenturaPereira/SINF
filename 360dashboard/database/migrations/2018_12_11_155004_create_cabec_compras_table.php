<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabecComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabec_compras', function (Blueprint $table) {

            $table->increments('id');
            $table->string('Entidade')->default(' ');
            $table->string('DataDoc')->default(' ');
            $table->string('NumDocExterno')->default(' ');
            $table->string('TotalMerc')->default(' ');
            $table->string('TotalIva')->default(' ');
            $table->string('TotalDesc')->default(' ');
            $table->string('NumContribuinte')->default(' ');
            $table->string('Nome')->default(' ');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cabec_compras');
    }
}
