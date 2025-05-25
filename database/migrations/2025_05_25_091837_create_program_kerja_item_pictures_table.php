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
        Schema::create('program_kerja_item_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_kerja_item_id')
                ->constrained('program_kerja_items')
                ->onDelete('cascade');
            $table->foreignId('picture_id')
                ->constrained('pictures')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_kerja_item_pictures');
    }
};
