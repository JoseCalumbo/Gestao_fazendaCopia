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
        Schema::create('talhoes', function (Blueprint $table) {

            $table->id();

            $table->string('designacao');

            $table->decimal('area', 10, 2);

            $table->string('cultura_actual')->nullable();

            $table->string('localizacao')->nullable();

            $table->enum('estado', [
                'Em cultivo',
                'Pousio',
                'Colhido',
                'activo',
                'inactivo',
            ])->default('activo');

            $table->foreignId('agricultor_id')
                  ->constrained('agricultores')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talhoes');
    }
};
