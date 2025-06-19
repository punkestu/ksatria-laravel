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
        Schema::table('program_kerja_items', function (Blueprint $table) {
            $table->float("rating")->default(0)->after('keterangan')->comment('Rating for the program kerja item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_kerja_items', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
