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
        Schema::create('sorting_settings', function (Blueprint $table) {
            $table->id();
            $table->string('model'); // e.g., 'Product'
            $table->string('sort_column')->default('name');
            $table->string('sort_direction')->default('asc');
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
        Schema::dropIfExists('sorting_settings');
    }
};
