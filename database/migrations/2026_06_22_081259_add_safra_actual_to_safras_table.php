<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('safras', function (Blueprint $table) {
            $table->boolean('safra_actual')
                  ->default(false)
                  ->after('estado');
        });
    }

    public function down(): void
    {
        Schema::table('safras', function (Blueprint $table) {
            $table->dropColumn('safra_actual');
        });
    }
};