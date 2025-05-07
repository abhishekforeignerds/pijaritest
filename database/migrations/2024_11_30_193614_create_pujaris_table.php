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
        Schema::create('pujaris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pujari_code');
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('state')->nullable()->default('[]');
            $table->string('city')->nullable()->default('[]');
            $table->string('pincode')->nullable()->default('[]');
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('ban')->default(1);
            $table->string('language')->nullable()->default('[]');
            $table->string('verified')->default('0');
            $table->rememberToken();
            $table->integer('otp')->nullable();
            $table->double('balance', 8, 2)->default(0);
            $table->double('admin_to_pay', 8, 2)->default(0);
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('pujaris');
    }
};
