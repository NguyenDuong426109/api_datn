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
        Schema::create('oder', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->nullable();
            $table->text('order_note')->nullable();
            $table->integer('totalMoney')->nullable();
            $table->integer('payment_status')->default(1)->nullable();
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
        Schema::dropIfExists('oder');
    }
};
