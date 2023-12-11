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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users');
            $table->integer('total_escort')->default(1);
            $table->enum('escort_type', ['male', 'female'])->default('female');
            $table->boolean('is_group_order')->default(false);
            $table->integer('total_male')->nullable();
            $table->integer('total_female')->nullable();
            $table->string('meeting_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
