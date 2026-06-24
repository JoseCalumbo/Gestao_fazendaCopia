<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cooperativa_id')
                ->constrained('cooperativas')
                ->cascadeOnDelete();

            $table->foreignId('agricultor_id')
                ->nullable()
                ->constrained('agricultores')
                ->nullOnDelete();

            $table->date('data_venda');

            $table->string('cliente');

            $table->decimal('valor_total', 12, 2)
                ->default(0);

            $table->enum('forma_pagamento', [
                'Dinheiro',
                'Transferencia',
                'Multicaixa',
                'Credito'
            ]);

            $table->text('observacoes')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};