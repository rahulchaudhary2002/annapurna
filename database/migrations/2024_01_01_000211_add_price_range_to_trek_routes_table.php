<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trek_routes', function (Blueprint $table) {
            $table->string('price_range')->nullable()->after('total_distance');
            $table->integer('group_size_min')->nullable()->after('price_range');
        });
    }

    public function down(): void
    {
        Schema::table('trek_routes', function (Blueprint $table) {
            $table->dropColumn(['price_range', 'group_size_min']);
        });
    }
};
