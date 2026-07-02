<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trek_routes', function (Blueprint $table) {
            $table->json('attractions')->nullable()->after('faqs');
        });
    }

    public function down(): void
    {
        Schema::table('trek_routes', function (Blueprint $table) {
            $table->dropColumn('attractions');
        });
    }
};
