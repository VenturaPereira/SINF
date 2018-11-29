<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->string('SupplierID');
            $table->integer('AccountID');
            $table->integer('SupplierTaxID');
            $table->string('CompanyName');
            $table->string('BillingAddress_AddressDetail');
            $table->string('BillingAddress_City');
            $table->string('BillingAddress_PostalCode');
            $table->string('BillingAddress_Country');
            $table->string('ShipFromAddress_AddressDetail');
            $table->string('ShipFromAddress_City');
            $table->string('ShipFromAddress_PostalCode');
            $table->string('ShipFromAddress_Country');
            $table->integer('Telephone');
            $table->integer('Fax');
            $table->string('Website')->default('www');
            $table->string('SelfBillingIndicator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
