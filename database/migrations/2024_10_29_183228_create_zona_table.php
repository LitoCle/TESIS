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
        Schema::create('zona', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 10);
            $table->unsignedBigInteger('fk_localidad');

            //índices
            $table->index('fk_localidad', 'fk_localidad_zona');

            //Llaves foráneas
            $table->foreign('fk_localidad', 'fk_localidad_zona')
             ->references('id')
            ->on('localidad')
            ->onDelete('cascade');
            //$table->unsignedBigInteger('fk_coordenadasGeograficas');

            //Indices
            //$table->index('fk_coordenadasGeograficas', 'fk_coordenadasGeograficas_zona');

            //Clave foránea
           // $table->foreign('fk_coordenadasGeograficas', 'fk_coordenadasGeograficas_zona')
            //->references('id')
            //->on('coordenadas_geograficas')
            //->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona');
    }
};
