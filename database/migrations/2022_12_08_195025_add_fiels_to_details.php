<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFielsToDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cnnxn_quotation_details', function (Blueprint $table) {
            $table->decimal('cost')->after('quantity')->default(0);
            $table->decimal('rubber')->after('cost')->default(0);
            $table->decimal('total_cost')->after('rubber')->default(0);
            $table->decimal('total_rubber')->after('total_cost')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cnnxn_quotation_details', function (Blueprint $table) {
            $table->dropColumn('cost');
            $table->dropColumn('rubber');
            $table->dropColumn('total_cost');
            $table->dropColumn('total_rubber');
        });
    }
}
