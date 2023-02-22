<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnnxnQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cnnxn_quotations', function (Blueprint $table) {
            $table->id('idQt')->autoIncrement();
            $table->string('slug');
            $table->integer('invoice')->default(0);
            $table->decimal('amount')->nullable();
            $table->decimal('tax')->default(0);
            $table->decimal('total')->nullable();
            $table->integer('status')->default(0);
            $table->integer('idCustomer');
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
        Schema::dropIfExists('cnnxn_quotations');
    }
}
