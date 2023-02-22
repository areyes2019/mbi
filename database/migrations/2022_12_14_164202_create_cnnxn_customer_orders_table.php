<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnnxnCustomerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cnnxn_customer_orders', function (Blueprint $table) {
            $table->id('idOrder');
            $table->string('slug');
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->date('delivered')->nullable();
            $table->integer('delivery_type')->nullable();
            $table->date('delivery_day')->nullable();
            $table->time('delivery_time')->nullable();
            $table->decimal('delivery_cost')->nullable();
            $table->string('art_img')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('zone')->nullable();
            $table->string('receiber')->nullable();
            $table->string('details')->nullable();
            $table->decimal('amount')->nullable();
            $table->decimal('advance_payment')->nullable();
            $table->decimal('total')->nullable();
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
        Schema::dropIfExists('cnnxn_customer_orders');
    }
}
