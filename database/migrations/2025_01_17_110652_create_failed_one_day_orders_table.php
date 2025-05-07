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
        Schema::create('failed_one_day_orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('shipping_address')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_details')->nullable();
            $table->string('grand_total')->nullable();
            $table->integer('total_paid')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount')->nullable();
            $table->string('alternate_contact')->nullable();
            $table->string('gotra')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->default('[]');
            $table->string('is_prashad')->default(0);
            $table->string('code');
            $table->string('date')->nullable();
            $table->string('product_id')->nullable();
            $table->string('package_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('package_name')->nullable();
            $table->string('product_image')->nullable();
            $table->string('inclusion')->nullable();
            $table->string('city')->nullable();
            $table->string('language')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->string('price')->nullable();
            $table->string('dakshina')->nullable();
            $table->string('inclusion_price')->nullable();
            $table->string('pujari_id')->nullable();
            $table->string('pujari_comission')->nullable();
            $table->string('pujari_status')->nullable();
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
        Schema::dropIfExists('failed_one_day_orders');
    }
};
