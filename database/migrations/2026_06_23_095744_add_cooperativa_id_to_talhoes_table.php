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
        Schema::table('talhoes', function (Blueprint $table) {
            // Adiciona a chave estrangeira após a coluna agricultor_id
            $table->foreignId('cooperativa_id')
                  ->after('agricultor_id') 
                  ->constrained('cooperativas')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talhoes', function (Blueprint $table) {
            // Remove a chave estrangeira e a coluna caso precise fazer rollback
            $table->dropForeign(['cooperativa_id']);
            $table->dropColumn('cooperativa_id');
        });
    }
};