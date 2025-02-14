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
        Schema::create('parametre_batteries', function (Blueprint $table) {
            $table->id();
            $table->decimal('plage_temperature_min', 8, 2); 
            $table->decimal('plage_temperature_max', 8, 2);
            $table->decimal('plage_tension_min', 8, 2); 
            $table->decimal('plage_tension_max', 8, 2);
            $table->decimal('plage_courant_min', 8, 2); 
            $table->decimal('plage_courant_max', 8, 2);
            $table->decimal('plage_puissance_min', 8, 2); 
            $table->decimal('plage_puissance_max', 8, 2);
            $table->decimal('seuil_alerte_soc', 8, 2); 
            $table->decimal('seuil_alerte_dod', 8, 2);
            $table->decimal('profondeur_charge_max', 8, 2); // Suppression de l'espace
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametre_batteries');
    }
};
