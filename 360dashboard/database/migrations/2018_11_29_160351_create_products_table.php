<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('ProductCode')->default(' ');
            $table->string('ProductPrice')->default(' ');
            $table->string('ProductDescription')->default(' ');
            $table->string('ProductSupplier')->default(' ');
            $table->string('StkMin')->default(' ');
            $table->string('StkMax')->default(' ');
            $table->string('StkReposition')->default(' ');
            $table->string('StkCurrent')->default(' ');
            $table->string('PCMed')->default(' ');
            $table->string('PCLast')->default(' ');
            $table->string('DateLastEntrance')->default(' ');
            $table->string('DateLastOutput')->default(' ');
            $table->string('ProductSales')->default(' ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
