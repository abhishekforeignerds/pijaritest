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
        Schema::table('inclusions', function (Blueprint $table) {
            $table->string('description_english')->nullable()->after('inclusion_hindi');
            $table->string('description_hindi')->nullable()->after('description_english');
            $table->string('product_id')->nullable()->after('package_id');
            $table->string('image')->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inclusions', function (Blueprint $table) {
            $table->dropColumn('description_english');
            $table->dropColumn('description_hindi');
            $table->dropColumn('product_id');
            $table->dropColumn('image');
        });
    }
};
