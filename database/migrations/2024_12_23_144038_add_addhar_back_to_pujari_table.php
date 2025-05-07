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
        Schema::table('pujaris', function (Blueprint $table) {
            $table->string('aadhaar_card_back')->after('admin_to_pay')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pujaris', function (Blueprint $table) {
            $table->dropColumn('aadhaar_card_back');
        });
    }
};
