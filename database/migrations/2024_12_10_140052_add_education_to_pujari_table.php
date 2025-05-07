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
            $table->string('passbook_image')->after('admin_to_pay')->nullable();
            $table->string('checkbook_image')->after('admin_to_pay')->nullable();
            $table->string('qualification')->after('admin_to_pay')->nullable()->default('[]');
            $table->string('qualification_image')->after('admin_to_pay')->nullable()->default('[]');
            $table->string('pan_card')->after('admin_to_pay')->nullable();
            $table->string('aadhaar_card')->after('admin_to_pay')->nullable();
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
            $table->dropColumn('passbook_image');
            $table->dropColumn('checkbook_image');
            $table->dropColumn('qualification')->default('[]');
            $table->dropColumn('qualification_image')->default('[]');
            $table->dropColumn('pan_card');
            $table->dropColumn('aadhaar_card');
        });
    }
};
