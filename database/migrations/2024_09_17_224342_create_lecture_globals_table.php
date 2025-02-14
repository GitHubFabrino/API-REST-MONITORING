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
        Schema::create('lecture_globals', function (Blueprint $table) {
            $table->id();
            $table->decimal('tension_total', 8, 2); // Valeurs décimales avec 2 chiffres après la virgule
            $table->decimal('courant_total', 8, 2); // Même chose pour le courant
            $table->decimal('temperature_moyenne', 5, 2); // Valeur décimale pour la température
            $table->integer('soc_global'); // SoC en pourcentage (entier)
            $table->integer('dod_global'); // DoD en pourcentage (entier)
            $table->timestamp('horodatage'); // Type de champ adapté pour l'horodatage
            $table->foreignId('parc_id')->constrained()->onDelete('cascade'); // clé étrangère vers la table batteries
            $table->timestamps(); // Crée les champs created_at et updated_at automatiquement
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_globals');
    }
};
