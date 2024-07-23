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
        if (Schema::hasTable('marques')) {
            Schema::create('modeles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('marque_id');
                $table->timestamps();

                $table->foreign('marque_id')->references('id')->on('marques')->onDelete('cascade');
            });
        } else {
            throw new Exception('Table marques does not exist.');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modeles');
    }
};
