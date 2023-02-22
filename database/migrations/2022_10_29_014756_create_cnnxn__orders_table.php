<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnnxnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cnnxn_orders', function (Blueprint $table) {
            $table->id('idOrder')->autoIncrement();
            $table->string('slug');
            $table->integer('status')->default(0);
            $table->string('link')->default(0);
            $table->integer('stock')->default(0);
            $table->decimal('sub_total')->nullable();
            $table->decimal('tax')->default(0);
            $table->decimal('total')->nullable();
            $table->integer('idSupplier');
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
        Schema::dropIfExists('cnnxn_orders');
    }
}
