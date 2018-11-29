<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('CustomerID');
            $table->integer('AccountID');
            $table->integer('CustomerTaxID');
            $table->string('CompanyName');
            $table->string('BillingAddress_AddressDetail');
            $table->string('BillingAddress_City');
            $table->string('BillingAddress_PostalCode');
            $table->string('BillingAddress_Country');
            $table->string('ShipToAddress_AddressDetail');
            $table->string('ShipToAddress_City');
            $table->string('ShipToAddress_PostalCode');
            $table->string('ShipToAddress_Country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
