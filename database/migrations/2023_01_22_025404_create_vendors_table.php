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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('category_id');
            $table->string('business_name')->nullable();
            $table->string('legal_business_name')->nullable();
            $table->string('building')->nullable();
            $table->string('street')->nullable();
            $table->string('landmark')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('service_id')->on('services')->references('id')->onDelete('cascade');
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('vendors');
    }
};
