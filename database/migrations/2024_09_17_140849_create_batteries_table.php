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
        Schema::create('batteries', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('capacite_nominal'); // Nom précis pour la capacité
            $table->string('date_installation');
            $table->string('technologie');
            $table->string('marque');
            $table->foreignId('parc_id')->constrained()->onDelete('cascade');
            $table->foreignId('parametre_batterie_id')->constrained('parametre_batteries')->onDelete('cascade'); // clé étrangère vers la table parametre_batteries

            // Ajout des nouveaux champs
            $table->string('description')->nullable();
            $table->string('tension_nominale')->nullable();
            $table->string('capacite')->nullable();
            $table->string('utilisation_veille')->nullable();
            $table->string('utilisation_cyclique')->nullable();
            $table->string('courant')->nullable();
            $table->string('temperature')->nullable();
            $table->string('dod_max')->nullable();
            
            

            $table->timestamps(); // Garder timestamps pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batteries');
    }
};
