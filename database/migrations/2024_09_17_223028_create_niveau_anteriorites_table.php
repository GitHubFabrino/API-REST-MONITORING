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
        Schema::create('niveau_anteriorites', function (Blueprint $table) {
            $table->id();
             $table->string('anterioriter');
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
        Schema::dropIfExists('niveau_anteriorites');
        Schema::enableForeignKeyConstraints();

    }
};
