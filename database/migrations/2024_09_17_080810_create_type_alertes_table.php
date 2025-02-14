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
         if (Schema::hasTable('type_alertes')) {
             Schema::drop('type_alertes'); 
        }

        Schema::create('type_alertes', function (Blueprint $table) {
            $table->id();
              $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
         Schema::dropIfExists('type_alertes');
          Schema::enableForeignKeyConstraints();
    }
};
