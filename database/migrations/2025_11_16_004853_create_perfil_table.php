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
            // 1. Eliminar atribuyo email_verified_at
            $table->dropColumn('email_verified_at');

            // 2, Renombrar name a español
            $table->renameColumn('name', 'nombre');

            if(!Schema::hasColumn('users', 'perfil')){
                $table->enum('perfil', ['administrador', 'editor', 'usuario'])
                    ->default('usuario')
                    ->after('nombre');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->timestamp('email_verified_at')->nullable();
            $table->renameColumn('nombre', 'name');

            if (Schema::hasColumn('users', 'perfil')) {
                $table->dropColumn('perfil');
            }
        });
    }
};
