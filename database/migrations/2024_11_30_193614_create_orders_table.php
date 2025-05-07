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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('shipping_address')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_details')->nullable();
            $table->string('grand_total')->nullable();
            $table->integer('total_paid')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount')->nullable();
            $table->string('wallet_discount')->nullable();
            $table->string('coupon_discount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('rashi_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('gotra')->nullable();
            $table->string('varn')->nullable();
            $table->string('wife_name')->nullable();
            $table->string('code');
            $table->string('date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
