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
        Schema::table('users', function (Blueprint $table) {

            $table->string('telefone')->nullable()->after('email');

            $table->enum('estado', [
                'activo',
                'inactivo'
            ])->default('activo')->after('nivel');

            $table->timestamp('ultimo_acesso')
                  ->nullable()
                  ->after('estado');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'telefone',
                'estado',
                'ultimo_acesso'
            ]);

        });
    }
};
