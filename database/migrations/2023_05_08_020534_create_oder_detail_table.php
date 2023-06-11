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
        Schema::create('oder_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable()->unsigned();
            $table->integer('product_id')->nullable()->unsigned();
            $table->integer('size_id')->nullable()->unsigned();
            $table->integer('color_id')->nullable()->unsigned();
            $table->string('img_oder',255)->nullable();
            $table->integer('quantity')->nullable()->unsigned();
            $table->integer('price')->nullable()->unsigned();
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
        Schema::dropIfExists('oder_details');
    }
};
