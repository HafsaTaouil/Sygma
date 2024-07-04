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
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 255);
            $table->string('previous_registration', 255);
            $table->date('first_registration');
            $table->date('MC_maroc');
            $table->string('usage', 255);
            $table->string('owner', 255);
            $table->string('address', 255);
            $table->date('validity_end');
            $table->string('type', 255);
            $table->string('genre', 255);
            $table->string('fuel_type', 255);
            $table->string('chassis_nbr', 255);
            $table->string('cylinder_nbr')->nullable();
            $table->string('fiscal_power')->nullable();
            $table->foreignId('modele_id')->constrained()->onDelete('cascade');
            $table->string('cartegrise_recto')->nullable();
            $table->string('cartegrise_verso')->nullable();
            $table->string('permis_recto')->nullable();
            $table->string('permis_verso')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_dossiers');
    }
};
