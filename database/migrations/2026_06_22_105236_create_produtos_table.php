<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            
            // Chaves Estrangeiras (Relacionamentos)
            // O constrained() assume que as tabelas se chamam cooperativas, agricultores e talhoes
            $table->foreignId('cooperativa_id')->constrained('cooperativas ')->onDelete('cascade');
            $table->foreignId('agricultor_id')->constrained('agricultores')->onDelete('cascade');
            $table->foreignId('talhao_id')->constrained('talhoes')->onDelete('cascade');
            
            // Campos do Produto
            $table->string('nome');
            $table->string('categoria')->nullable();
            $table->decimal('quantidade', 10, 2)->default(0);
            $table->string('unidade', 20); // kg, litros, etc.
            $table->decimal('preco_venda', 10, 2)->nullable();
            $table->string('estado')->default('disponivel'); // disponivel, esgotado
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};