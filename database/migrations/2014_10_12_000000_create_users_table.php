<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Models\User\UserForm;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_sn');
            $table->string('provider_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('user_form')->default(UserForm::MENTI->value);
            $table->string('cat_breed');
            $table->integer('cat_age');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
