<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('batteries', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->nullable()->after('temperature');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('batteries', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
            $table->dropColumn('file_id');
        });
    }
    
};
