<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemsToAccountings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('connxn__accountings', function (Blueprint $table) {
            $table->integer('quotation')->after('id');
            $table->decimal('amount')->after('quotation');
            $table->decimal('production_cost')->after('amount');
            $table->decimal('profit')->after('production_cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connxn__accountings', function (Blueprint $table) {
            $table->dropColumn('quotation');
            $table->dropColumn('amount');
            $table->dropColumn('production_cost');
            $table->dropColumn('profit');
        });
    }
}
