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
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('package_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('package_name')->nullable();
            $table->string('product_image')->nullable();
            $table->string('inclusion')->nullable();
            $table->string('city')->nullable();
            $table->string('language')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->string('price')->nullable();
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
        Schema::dropIfExists('order_details');
    }
};
