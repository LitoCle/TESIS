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
        Schema::create('localidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
           // $table->unsignedBigInteger('fk_zona');

            //índices
            //$table->index('fk_zona', 'fk_zona_localidad');

            //Llaves foráneas
            //$table->foreign('fk_zona', 'fk_zona_localidad')
           // ->references('id')
           // ->on('zona')
           // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localidad');
    }
};
