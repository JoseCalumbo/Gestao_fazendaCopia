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
        Schema::create('movimento_insumos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cooperativa_id')
                ->constrained('cooperativas')
                ->cascadeOnDelete();

            $table->foreignId('insumo_id')
                ->constrained('insumos')
                ->cascadeOnDelete();

            $table->foreignId('agricultor_id')
                ->nullable()
                ->constrained('agricultores')
                ->nullOnDelete();

            $table->enum('tipo', [
                'entrada',
                'saida'
            ]);

            $table->decimal('quantidade', 10, 2);

            $table->enum('modalidade', [
                'compra',
                'oferta',
                'distribuicao',
                'credito',
                'troca'
            ]);
            $table->enum('estado', [
                'pago',
                'pedente',
                'Oferecido',
                'liquidado'
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimento_insumos');
    }
};
