<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cooperativa_membros', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cooperativa_id')
                  ->constrained('cooperativas')
                  ->onDelete('cascade');

            $table->foreignId('agricultor_id')
                  ->constrained('agricultores')
                  ->onDelete('cascade');

            $table->string('cargo')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cooperativa_membros');
    }
};