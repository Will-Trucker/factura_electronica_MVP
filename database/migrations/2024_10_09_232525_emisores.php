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
        Schema::table('emisores',function(Blueprint $table){
            $table->id('id');
            $table->string('Nombre');
            $table->string('NombreComercial');
            $table->string('idActividadEconomica');
            $table->string('NIT');
            $table->string('NRC');
            $table->string('idDepartamento');
            $table->string('idMunicipio');
            $table->string('Complemento');
            $table->string('Telefono');
            $table->string('Correo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
