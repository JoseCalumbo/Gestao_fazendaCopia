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
        Schema::create('agricultores', function (Blueprint $table) {
            $table->id();

            // Dados pessoais
            $table->string('nome_completo');
            $table->enum('sexo', ['Masculino', 'Feminino']);
            $table->date('data_nascimento');
            $table->string('bilhete')->unique();

            $table->string('nif')->nullable();
            $table->string('estado_civil')->nullable();


            // Fotografia
            $table->string('foto')->nullable();

            // Contactos
            $table->string('telefone_principal');
            $table->string('telefone_alternativo')->nullable();

            $table->string('email')->nullable();

            // Morada
            $table->text('endereco');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agricultores');
    }
};
