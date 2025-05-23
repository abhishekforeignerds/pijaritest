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
        Schema::create('our_pujaris', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_hindi')->nullable();
            $table->string('city')->nullable();
            $table->string('city_hindi')->nullable();
            $table->string('exp')->nullable();
            $table->string('image')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('our_pujaris');
    }
};
