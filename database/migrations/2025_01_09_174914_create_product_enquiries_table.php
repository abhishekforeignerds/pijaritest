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
        Schema::create('product_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('phone')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('package_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('puja_details')->nullable();
            $table->bigInteger('user_details')->nullable();
            $table->softDeletes()->index();
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
        Schema::dropIfExists('product_enquiries');
    }
};
