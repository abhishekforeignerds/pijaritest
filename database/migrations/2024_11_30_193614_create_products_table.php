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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_hindi')->nullable();
            $table->string('category_id')->nullable();
            $table->string('product_type')->nullable();
            $table->string('date')->nullable();
            $table->string('category')->nullable()->default('[]');
            $table->string('city')->nullable()->default('[]');
            $table->string('pincode')->nullable()->default('[]');
            $table->string('language')->nullable()->default('[]');
            $table->string('tag')->nullable();
            $table->string('photos')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->string('short_description_hindi')->nullable();
            $table->string('key_insight')->nullable();
            $table->string('key_insight_hindi')->nullable();
            $table->string('promise')->nullable();
            $table->string('promise_hindi')->nullable();
            $table->string('faq')->nullable();
            $table->string('faq_hindi')->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_hindi')->nullable();
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('upcoming')->default(false);
            $table->boolean('location_type')->default(false);
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
        Schema::dropIfExists('products');
    }
};
