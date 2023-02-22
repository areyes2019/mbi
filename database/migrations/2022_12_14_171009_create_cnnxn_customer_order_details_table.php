<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnnxnCustomerOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cnnxn_customer_order_details', function (Blueprint $table) {
            $table->id('idDetail_order');
            $table->integer('quantity');
            $table->integer('article');
            $table->string('name');
            $table->string('color');
            $table->integer('idOrder_customer');
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
        Schema::dropIfExists('cnnxn_customer_order_details');
    }
}
