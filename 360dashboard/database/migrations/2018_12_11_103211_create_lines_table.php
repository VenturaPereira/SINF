<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->string('InvoiceNo');
            $table->string('ProductCode')->default(' ');
            $table->string('ProductDescription')->default(' ');
            $table->string('Quantity')->default(' ');
            $table->string('UnitOfMeasure')->default(' ');
            $table->string('UnitPrice')->default(' ');
            $table->string('TaxPointDate')->default(' ');
            $table->string('Description')->default(' ');
            $table->string('CreditAmount')->default(' ');

            $table->string('Tax_TaxType')->default(' ');
            $table->string('Tax_TaxCountryRegion')->default(' ');
            $table->string('Tax_TaxCode')->default(' ');
            $table->string('Tax_TaxPercentage')->default(' ');

            $table->string('SettlementAmount')->default(' ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lines');
    }
}
