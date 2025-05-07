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
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title_hindi')->nullable()->after('title');
            $table->string('short_description_hindi')->nullable()->after('short_description');
            $table->text('description_hindi')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('title_hindi');
            $table->dropColumn('short_description_hindi');
            $table->dropColumn('description_hindi');
        });
    }
};
