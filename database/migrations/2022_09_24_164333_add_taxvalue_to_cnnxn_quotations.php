<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxvalueToCnnxnQuotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cnnxn_quotations', function (Blueprint $table) {
            $table->integer('with_tax')->after('tax')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cnnxn_quotations', function (Blueprint $table) {
            $table->integer('with_tax')->after('tax')->default(1);
        });
    }
}
