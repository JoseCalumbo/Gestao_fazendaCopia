<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insumos', function (Blueprint $table) {

            $table->id();

            $table->string('nome');

            $table->text('descricao')->nullable();

            $table->enum('tipo', [
                'fertilizante',
                'semente',
                'mecanico',
                'pesticida',
                'outro'
            ]);

            $table->decimal('quantidade', 15, 2)->default(0);

            $table->decimal('stock_minimo', 15, 2)->default(0);

            $table->string('unidade');

            $table->decimal('preco_unitario', 15, 2);

            $table->date('data_entrada');

            $table->enum('estado', [
                'ativo',
                'desativado'
            ])->default('ativo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};