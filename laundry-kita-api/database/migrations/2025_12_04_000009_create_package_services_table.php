<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('regular_group_name', 100);
            $table->string('image_path')->nullable();
            $table->unsignedInteger('price');
            $table->string('quota');
            $table->unsignedSmallInteger('work_hours'); // waktu pengerjaan (jam)
            $table->boolean('has_expiry')->default(false);
            $table->unsignedSmallInteger('expires_in_days')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'regular_group_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_services');
    }
};
