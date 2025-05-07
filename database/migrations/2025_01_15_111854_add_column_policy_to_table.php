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
        Schema::table('policies', function (Blueprint $table) {
            $table->longText('how_we_work_hindi')->nullable()->after('how_we_work');
            $table->longText('terms_and_conditions_hindi')->nullable()->after('terms_and_conditions');
            $table->longText('shipping_policy_hindi')->nullable()->after('shipping_policy');
            $table->longText('return_policy_hindi')->nullable()->after('return_policy');
            $table->longText('privacy_policy_hindi')->nullable()->after('privacy_policy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policies', function (Blueprint $table) {
            //
        });
    }
};
