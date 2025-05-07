<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payment_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->string('user_id');
            $table->string('amount')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('transaction_detail')->nullable();
            $table->string('payment_details')->nullable();
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
        Schema::dropIfExists('order_payment_transactions');
    }
};
