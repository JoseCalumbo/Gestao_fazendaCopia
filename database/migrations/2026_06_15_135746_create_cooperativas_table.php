<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cooperativas', function (Blueprint $table) {

            $table->id();

            $table->string('nome');

            $table->string('nif')->unique();

            $table->date('data_fundacao')->nullable();

            $table->text('descricao')->nullable();

            $table->string('telefone', 30)->nullable();

            $table->string('email')->nullable();

            $table->string('website')->nullable();

            $table->string('provincia');

            $table->string('municipio');

            $table->string('comuna')->nullable();

            $table->string('endereco')->nullable();

            $table->integer('numero_socios')->default(0);

            $table->string('principal_cultura')->nullable();

            $table->integer('numero_talhoes')->default(0);

            $table->decimal('producao_estimada', 12, 2)->default(0);

            $table->decimal('area_total_cultivada', 12, 2)->default(0);

            $table->string('safra')->nullable();

            $table->date('inicio_safra')->nullable();

            $table->date('fim_previsto_safra')->nullable();

            $table->enum('estado', [
                'activo',
                'desactivado',
            ])->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cooperativas');
    }
};
