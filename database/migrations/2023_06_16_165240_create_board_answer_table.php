<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('board_answer', function (Blueprint $table) {
            $table->bigIncrements('board_a_sn');
            $table->string('content');
            $table->boolean('choose_yn')->default(0);
            $table->unsignedBigInteger('board_q_sn');
            $table->unsignedBigInteger('crt_user_sn');
            $table->dateTime('crt_dt');
            $table->dateTime('udt_dt');
            $table->softDeletes('del_dt');

            $table->foreign('crt_user_sn')->references('user_sn')->on('users');
            $table->foreign('board_q_sn')->references('board_q_sn')->on('board_question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_answer');
    }
};
