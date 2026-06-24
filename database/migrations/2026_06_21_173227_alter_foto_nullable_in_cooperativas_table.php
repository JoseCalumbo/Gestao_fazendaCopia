<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cooperativas', function (Blueprint $table) {
            // Modifica a coluna foto para permitir valores nulos de forma segura
            $table->string('foto')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('cooperativas', function (Blueprint $table) {
            // Caso queiras reverter, volta a ser obrigatória
            $table->string('foto')->nullable(false)->change();
        });
    }
};