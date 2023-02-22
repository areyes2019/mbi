<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnnxnQuotationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cnnxn_quotation_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('article');
            $table->decimal('unit_price');
            $table->decimal('total');
            $table->integer('idQuotation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cnnxn_quotation_details');
    }
}
