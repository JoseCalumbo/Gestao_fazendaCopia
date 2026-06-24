<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insumos', function (Blueprint $table) {
            $table->foreignId('cooperativa_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('cooperativas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('insumos', function (Blueprint $table) {
            $table->dropForeign(['cooperativa_id']);
            $table->dropColumn('cooperativa_id');
        });
    }
};
