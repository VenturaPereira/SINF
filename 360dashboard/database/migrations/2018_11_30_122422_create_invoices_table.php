<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('InvoiceNo');
            $table->string('ATCUD')->default(' ');

            $table->string('DocumentStatus_InvoiceStatus')->default(' ');
            $table->string('DocumentStatus_InvoiceStatusDate')->default(' ');
            $table->string('DocumentStatus_SourceID')->default(' ');
            $table->string('DocumentStatus_SourceBilling')->default(' ');

            $table->string('Hash')->default(' ');
            $table->string('HashControl')->default(' ');
            $table->string('Period')->default(' ');
            $table->string('InvoiceDate')->default(' ');
            $table->string('InvoiceType')->default(' ');

            $table->string('SpecialRegimes_SelfBillingIndicator')->default(' ');
            $table->string('SpecialRegimes_CashVATSchemeIndicator')->default(' ');
            $table->string('SpecialRegimes_ThirdPartiesBillingIndicator')->default(' ');

            $table->string('SourceID')->default(' ');
            $table->string('SystemEntryDate')->default(' ');
            $table->string('CustomerID')->default(' ');

            $table->string('ShipTo_DeliveryDate')->default(' ');
            $table->string('ShipTo_Address_AddressDetail')->default(' ');
            $table->string('ShipTo_Address_City')->default(' ');
            $table->string('ShipTo_Address_PostalCode')->default(' ');
            $table->string('ShipTo_Address_Country')->default(' ');

            $table->string('ShipFrom_DeliveryDate')->default(' ');
            $table->string('ShipFrom_Address_AddressDetail')->default(' ');
            $table->string('ShipFrom_Address_City')->default(' ');
            $table->string('ShipFrom_Address_PostalCode')->default(' ');
            $table->string('ShipFrom_Address_Country')->default(' ');

            $table->string('MovementStartTime')->default(' ');

            //Note
            //This requires Lines so there is a Line table for that with reference attribute to this Invoice

            $table->string('DocumentTotals_TaxPayable')->default(' ');
            $table->string('DocumentTotals_NetTotal')->default(' ');
            $table->string('DocumentTotals_GrossTotal')->default(' ');

            $table->string('WithholdingTax_WithholdingTaxAmount')->default(' ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
