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
        Schema::create('coordenadas_geograficas', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);

            $table->unsignedBigInteger('fk_zona');

            //Indices
            $table->index('fk_zona', 'fk_zona_coordenadasGeograficas');

            //Clave foránea
            $table->foreign('fk_zona', 'fk_zona_coordenadasGeograficas')
             ->references('id')
             ->on('zona')
             ->onDelete('cascade');
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordenadas_geograficas');
    }
};
