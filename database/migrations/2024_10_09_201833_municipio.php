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
            Schema::create('municipio', function (Blueprint $table) {
                $table->id('idMunicipio'); // Llave primaria
                $table->string('codMunicipio');
                $table->string('nombreMunicipio');
                $table->string('idDepartamento');
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
