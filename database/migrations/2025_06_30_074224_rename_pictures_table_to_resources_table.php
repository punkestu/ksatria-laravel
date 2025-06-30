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
        Schema::rename('pictures', 'resources');

        Schema::table('resources', function (Blueprint $table) {
            $table->string('type')->default('image')->after('url');
            $table->string('description')->nullable()->after('type');
            $table->string('alt_text')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('resources', 'pictures');

        Schema::table('pictures', function (Blueprint $table) {
            $table->dropColumn(['type', 'description', 'alt_text']);
        });
    }
};
