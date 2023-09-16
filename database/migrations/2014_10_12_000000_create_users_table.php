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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('gender')->nullable();
            $table->string('sexual_preference')->nullable();
            $table->json('interested_in')->nullable();
            $table->string('kinks')->nullable();
            $table->string('bio')->nullable();
            $table->boolean('is_escort')->default(false);
            $table->string('impression')->nullable();
            // filters
            $table->string('location')->nullable();
            $table->string('tags')->nullable();
            $table->string('api_token')->nullable();
            $table->enum('plans', ['freemium', 'standard', 'premium'])->default('freemium');
            $table->json('metadata')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at')->nullable();
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
