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
        Schema::create('parcs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_parc');
            $table->string('description');
            $table->string('adresse');
            $table->string('email');
            $table->string('nombre_batteries');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            //  $table->foreignId('systeme_parametre_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        // Drop table
        Schema::dropIfExists('parcs');
        Schema::enableForeignKeyConstraints();

    }
};
