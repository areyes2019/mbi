<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToCnnxnQuotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cnnxn_quotations', function (Blueprint $table) {
            $table->renameColumn('amount','money_discount')->default(0);
            $table->integer('percent_discount')->after('total')->default(0);
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
            $table->renameColumn('money_discount','amount')->default(0);
            $table->integer('percent_discount')->after('total')->default(0);
        });
    }
}
