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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->decimal('tension', 8, 2); // Valeurs décimales avec 2 chiffres après la virgule
            $table->decimal('courant', 8, 2); // Même chose pour le courant
            $table->decimal('temperature', 5, 2); // Valeur décimale pour la température
            $table->integer('soc'); // SoC en pourcentage (entier)
            $table->integer('dod'); // DoD en pourcentage (entier)
            // $table->timestamp('horodatage'); // Type de champ adapté pour l'horodatage
            $table->foreignId('batterie_id')->constrained()->onDelete('cascade'); // clé étrangère vers la table batteries
            $table->timestamps(); // Crée les champs created_at et updated_at automatiquement
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
