<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('days')->nullable(); // contoh: "Senin - Sabtu"
            $table->unsignedInteger('quota')->default(0);
            $table->timestamps();
        });

        Schema::create('attendance_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('default');
            $table->unsignedInteger('grace_minutes')->default(15);
            $table->boolean('require_gps')->default(true);
            $table->boolean('require_selfie')->default(false);
            $table->boolean('require_fingerprint')->default(false);
            $table->decimal('geofence_lat', 10, 7)->nullable();
            $table->decimal('geofence_lng', 10, 7)->nullable();
            $table->unsignedInteger('geofence_radius_m')->default(200);
            $table->timestamps();
        });

        Schema::create('employee_grades', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5);
            $table->string('role');
            $table->unsignedInteger('allowance')->nullable();
            $table->string('benefit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_grades');
        Schema::dropIfExists('attendance_rules');
        Schema::dropIfExists('shifts');
    }
};
