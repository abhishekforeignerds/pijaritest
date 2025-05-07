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
        Schema::table('pincodes', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('service_cities', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('inclusions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('languages', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pincodes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('service_cities', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('inclusions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('languages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
