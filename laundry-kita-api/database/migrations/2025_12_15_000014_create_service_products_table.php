<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained('service_units')->nullOnDelete();
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('reorder_point')->default(0);
            $table->timestamps();
            $table->unique(['user_id', 'sku']);
        });

        Schema::table('addons', function (Blueprint $table) {
            if (! Schema::hasColumn('addons', 'product_id')) {
                $table->foreignId('product_id')->nullable()->after('id')->constrained('service_products')->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('addons', function (Blueprint $table) {
            if (Schema::hasColumn('addons', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });

        Schema::dropIfExists('service_products');
    }
};
