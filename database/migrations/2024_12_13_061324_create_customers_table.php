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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('birthday');
            $table->string('phone')->nullable();
            $table->string('email_address')->unique();
            $table->boolean('email_verified')->default(false);
            $table->unsignedBigInteger('default_address_id')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
