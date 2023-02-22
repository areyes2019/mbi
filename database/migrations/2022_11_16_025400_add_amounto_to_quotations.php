<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountoToQuotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cnnxn_quotations', function (Blueprint $table) {
            $table->decimal('discount')->after('with_tax')->default(0);
            $table->decimal('amount')->after('discount')->default(0);
            $table->decimal('payment')->after('amount')->default(0);
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
            $table->dropColumn('amount');
            $table->dropColumn('discount');
            $table->dropColumn('payment');
        });
    }
}
