<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinhasComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('linhas_compras', function (Blueprint $table) {
            $table->string('Id');
            $table->string('IdCabecCompras');
            $table->string('NumLinha')->default(' ');
            $table->string('NumDocExterno')->default(' ');
            $table->string('Artigo')->default(' ');
            $table->string('Quantidade')->default(' ');
            $table->string('PrecUnit')->default(' ');
            $table->string('DataDoc')->default(' ');
            $table->string('DataEntrada')->default(' ');
            $table->string('DataEntrega')->default(' ');
            $table->string('PrecoLiquido')->default(' ');
            $table->string('TotalIva')->default(' ');
            $table->string('TotalIliquido')->default(' ');
            $table->string('Descricao')->default(' ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linhas_compras');
    }
}
