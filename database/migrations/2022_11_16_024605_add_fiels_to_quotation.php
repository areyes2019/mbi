<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFielsToQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cnnxn_quotations', function (Blueprint $table) {
            $table->dropColumn('money_discount');
            $table->dropColumn('tax');
            $table->dropColumn('sub_total');
            $table->dropColumn('total');
            $table->dropColumn('percent_discount');
            $table->dropColumn('percent_money');
            $table->dropColumn('balance');
            $table->dropColumn('advance_payment');
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
            $table->decimal('money_discount');
            $table->decimal('tax');
            $table->decimal('sub_total');
            $table->decimal('total');
            $table->integer('percent_discount');
            $table->decimal('percent_money');
            $table->decimal('balance');
            $table->decimal('advance_payment');
        });
    }
}
