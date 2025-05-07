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
        Schema::table('temple_details', function (Blueprint $table) {
            $table->string('title_hindi')->nullable();
            $table->string('description_hindi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temple_details', function (Blueprint $table) {
            $table->dropColumn('title_hindi');
            $table->dropColumn('description_hindi');
        });
    }
};
