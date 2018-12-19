<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('AccountID');
            $table->string('AccountDescription');
            $table->string('OpeningDebitBalance');
            $table->string('OpeningCreditBalance');
            $table->string('ClosingDebitBalance');
            $table->string('ClosingCreditBalance');
            $table->string('GroupingCategory');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
