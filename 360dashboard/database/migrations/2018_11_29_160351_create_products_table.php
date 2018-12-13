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
            $table->string('ProductStkMin')->default(' ');
            $table->string('ProductStkMax')->default(' ');
            $table->string('ProductStkCurrent')->default(' ');
            $table->string('ProductUnitaryPrice')->default(' ');
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