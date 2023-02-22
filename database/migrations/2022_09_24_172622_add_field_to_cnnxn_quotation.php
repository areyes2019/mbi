<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToCnnxnQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cnnxn_quotations', function (Blueprint $table) {
            $table->decimal('advance_payment')->after('total')->default(0);
            $table->decimal('balance')->after('total')->default(0);
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
            $table->decimal('advance_payment')->after('total')->default(0);
            $table->decimal('balance')->after('total')->default(0);
        });
    }
}
