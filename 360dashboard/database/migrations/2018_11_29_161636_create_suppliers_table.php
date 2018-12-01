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
            $table->string('SupplierID')->default(' ');
            $table->string('AccountID')->default(' ');
            $table->string('SupplierTaxID')->default(' ');
            $table->string('CompanyName')->default(' ');
            $table->string('BillingAddress_AddressDetail')->default(' ');
            $table->string('BillingAddress_City')->default(' ');
            $table->string('BillingAddress_PostalCode')->default(' ');
            $table->string('BillingAddress_Country')->default(' ');
            $table->string('ShipFromAddress_AddressDetail')->default(' ');
            $table->string('ShipFromAddress_City')->default(' ');
            $table->string('ShipFromAddress_PostalCode')->default(' ');
            $table->string('ShipFromAddress_Country')->default(' ');
            $table->string('Telephone')->default(' ');
            $table->string('Fax')->default(' ');
            $table->string('Website')->default('www');
            $table->string('SelfBillingIndicator')->default(' ');
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
