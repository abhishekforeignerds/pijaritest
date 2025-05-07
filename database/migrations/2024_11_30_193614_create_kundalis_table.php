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
        Schema::create('kundalis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('package_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('dob')->nullable();
            $table->string('tob')->nullable();
            $table->string('pob')->nullable();
            $table->string('language')->nullable();
            $table->string('pdf_type')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->nullable()->default('pending');
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
        Schema::dropIfExists('kundalis');
    }
};
