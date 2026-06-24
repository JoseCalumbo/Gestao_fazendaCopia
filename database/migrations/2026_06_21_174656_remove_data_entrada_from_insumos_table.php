<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insumos', function (Blueprint $table) {
            // Remove a coluna de forma definitiva
            $table->dropColumn('data_entrada');
        });
    }

    public function down(): void
    {
        Schema::table('insumos', function (Blueprint $table) {
            // Caso precises de fazer rollback, ela volta a existir
            $table->date('data_entrada')->nullable();
        });
    }
};