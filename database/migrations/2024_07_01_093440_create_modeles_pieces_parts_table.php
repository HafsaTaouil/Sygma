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
        Schema::create('modeles_pieces_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modele_id')->constrained()->onDelete('cascade');
            $table->foreignId('piece_id')->constrained()->onDelete('cascade');
            $table->foreignId('partie_id')->constrained()->onDelete('cascade');
            $table->integer('min_year');
            $table->integer('max_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modeles_pieces_parts');
    }
};
