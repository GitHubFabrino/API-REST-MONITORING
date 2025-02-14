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
        Schema::create('alerte_batteries', function (Blueprint $table) {
            $table->id();
            $table->float('valeur_alerte', 8, 2);
            $table->float('valeur_seuil', 8, 2);
            $table->string('message');
            $table->boolean('read')->default(false);
            $table->string('type');
            $table->string('graviter');
            // $table->foreignId('type_alerte_id')->constrained()->onDelete('cascade'); 
            // $table->foreignId('graviter_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('contact_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('batterie_id')->constrained()->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerte_batteries');
    }
};
