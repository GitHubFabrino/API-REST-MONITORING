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

        Schema::disableForeignKeyConstraints();
         if (Schema::hasTable('historique_mesures')) {
             Schema::drop('historique_mesures'); 
        }
        Schema::create('historique_mesures', function (Blueprint $table) {
            $table->id();
            $table->float('avg_tension', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('avg_courant', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('avg_temperature', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('avg_soc', 5, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('avg_dod', 5, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('avg_soh', 5, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('min_tension', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('max_tension', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('min_courant', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('max_courant', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('min_temperature', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('max_temperature', 8, 2); // Changer en float pour permettre les valeurs décimales
            $table->float('total_consommation', 8, 2); // Changer en float pour permettre les valeurs décimales

            $table->foreignId('niveau_anteriorite_id')
                ->constrained('niveau_anteriorites')
                ->onDelete('cascade');
                
            $table->foreignId('batterie_id')
                ->constrained('batteries')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('historique_mesures');
        Schema::enableForeignKeyConstraints();

    }
};
