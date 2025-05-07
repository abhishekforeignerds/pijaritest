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
        Schema::create('pujari_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('staff_id');
            $table->string('pujari_id');
            $table->string('amount')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('transaction_detail')->nullable();
            $table->string('payment_details')->nullable();
            $table->double('balance', 16, 2)->default(0);
            $table->string('approval')->nullable();
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
        Schema::dropIfExists('pujari_wallets');
    }
};
