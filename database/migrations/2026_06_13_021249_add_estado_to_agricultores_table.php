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
        Schema::table('agricultores', function (Blueprint $table) {

            // Estado do agricultor
            $table->enum('estado', [
                'Activo',
                'Desactivado',
                'Pendente',
            ])->default('Activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agricultores', function (Blueprint $table) {
            //
        });
    }
};
