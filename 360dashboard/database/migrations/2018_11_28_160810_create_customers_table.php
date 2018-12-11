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
            $table->string('CustomerID')->default(' ');
            $table->string('AccountID')->default(0);
            $table->string('CustomerTaxID')->default(0);
            $table->string('CompanyName')->default(' ');
            $table->string('BillingAddress_AddressDetail')->default(' ');
            $table->string('BillingAddress_City')->default(' ');
            $table->string('BillingAddress_PostalCode')->default(' ');
            $table->string('BillingAddress_Country')->default(' ');
            $table->string('ShipToAddress_AddressDetail')->default(' ');
            $table->string('ShipToAddress_City')->default(' ');
            $table->string('ShipToAddress_PostalCode')->default(' ');
            $table->string('ShipToAddress_Country')->default(' ');
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
