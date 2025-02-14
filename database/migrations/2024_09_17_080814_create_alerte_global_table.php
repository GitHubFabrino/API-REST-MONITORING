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
        Schema::create('alerte_globals', function (Blueprint $table) {
            $table->id();
            $table->string('valeur_alerte');
            $table->string('valeur_seuil');
            $table->timestamp('horodatage');
            $table->foreignId('type_alerte_id')->constrained()->onDelete('cascade');
            $table->foreignId('graviter_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerte_globals');
    }
};
