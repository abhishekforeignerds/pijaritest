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
        Schema::table('service_cities', function (Blueprint $table) {
            $table->string('city_name_hindi')->nullable();
            $table->string('state_name_hindi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_cities', function (Blueprint $table) {
            $table->dropColumn('city_name_hindi');
            $table->dropColumn('state_name_hindi');
        });
    }
};
