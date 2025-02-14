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
        Schema::create('systeme_parametres', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_batterie_serie');
            $table->string('nombre_batterie_parallele');
            $table->foreignId('type_montage_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('systeme_parametres');
    }
};
