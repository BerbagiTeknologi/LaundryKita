<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regular_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('group_name', 100);
            $table->string('name', 255);
            $table->unsignedInteger('price_per_kg');
            $table->unsignedSmallInteger('process_minutes'); // waktu proses per kg (menit)
            $table->timestamps();
            $table->index(['user_id', 'group_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regular_services');
    }
};
