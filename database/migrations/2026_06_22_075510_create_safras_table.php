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
        Schema::create('safras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cooperativa_id')
                ->constrained('cooperativas')
                ->onDelete('cascade');

            $table->string('nome');
            $table->integer('ano');

            $table->date('data_inicio');
            $table->date('data_fim');

            $table->enum('estado', [
                'Planeada',
                'Activa',
                'Encerrada',
            ])->default('Planeada');

            $table->text('descricao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safras');
    }
};
