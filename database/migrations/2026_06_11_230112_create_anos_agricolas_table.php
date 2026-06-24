<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anos_agricolas', function (Blueprint $table) {

            $table->id();

            $table->string('nome', 100);

            $table->date('data_inicio');

            $table->date('data_fim');

            $table->enum('estado', [
                'iniciado',
                'em_producao',
                'finalizado'
            ])->default('iniciado');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anos_agricolas');
    }
};
