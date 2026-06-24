<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_estoques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperativa_id')->constrained('cooperativas')->onDelete('cascade');
            $table->foreignId('insumo_id')->nullable()->constrained('insumos')->onDelete('set null');
            
            // ADICIONADO: Chave estrangeira para o Agricultor (nullable porque Entradas não têm agricultor)
            $table->foreignId('agricultor_id')->nullable()->constrained('agricultores')->onDelete('set null');
            
            // Permite ligar diretamente ao movimento se precisares de rastrear
            $table->unsignedBigInteger('movimento_id')->nullable(); 
            
            $table->string('tipo_movimento'); // 'Entrada' ou 'Saída'
            $table->decimal('quantidade', 10, 2);
            $table->decimal('stock_anterior', 10, 2);
            $table->decimal('stock_atual', 10, 2);
            $table->string('utilizador')->default('Sistema'); // Nome de quem fez a ação
            $table->text('observacao')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_estoques');
    }
};