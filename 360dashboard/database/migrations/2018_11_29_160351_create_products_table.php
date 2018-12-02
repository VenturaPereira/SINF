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
            $table->string('ProductType')->default(' ');
            $table->string('ProductCode')->default(' ');
            $table->string('ProductGroup')->default(' ');
            $table->string('ProductDescription')->default(' ');
            $table->string('ProductNumberCode')->default(' ');
            $table->string('ProductQuantity')->default(strval(rand(10,100)));
            $table->string('ProductSales')->default(strval(rand(4,50)));
            $table->string('ProductUnitaryPrice')->default(strval(rand(2,10)));
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
