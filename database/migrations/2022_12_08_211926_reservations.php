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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_1_id')->nullable();
            $table->integer('user_2_id')->nullable();
            $table->integer('user_3_id')->nullable();
            $table->integer('user_4_id')->nullable();
            $table->date('date');
            $table->string('time');
            $table->string('endtime')->nullable();
            $table->integer('track');
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
        //
    }
};
