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
        Schema::create('board_question', function (Blueprint $table) {
            $table->bigIncrements('board_q_sn');
            $table->string('subject');
            $table->string('content');
            $table->string('category');
            $table->unsignedBigInteger('crt_user_sn');
            $table->dateTime('crt_dt');
            $table->dateTime('udt_dt');
            $table->softDeletes('del_dt');

            $table->foreign('crt_user_sn')->references('user_sn')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_question');
    }
};
