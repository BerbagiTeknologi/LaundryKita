<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 50);
            $table->timestamps();
            $table->unique(['user_id', 'name']);
        });

        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->foreignId('unit_id')->nullable()->constrained('service_units')->nullOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'name']);
        });

        Schema::table('package_services', function (Blueprint $table) {
            $table->unsignedInteger('quota_value')->nullable()->after('quota');
            $table->foreignId('quota_unit_id')->nullable()->after('quota_value')->constrained('service_units')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('package_services', function (Blueprint $table) {
            if (Schema::hasColumn('package_services', 'quota_unit_id')) {
                $table->dropForeign(['quota_unit_id']);
                $table->dropColumn('quota_unit_id');
            }
            if (Schema::hasColumn('package_services', 'quota_value')) {
                $table->dropColumn('quota_value');
            }
        });

        Schema::dropIfExists('service_categories');
        Schema::dropIfExists('service_units');
    }
};
