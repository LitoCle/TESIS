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
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_registroDelito');

            //Indices
            $table->index('fk_registroDelito', 'fk_registroDelito_alertas');

            //Llaves foráneas
            $table->foreign('fk_registroDelito', 'fk_registroDelito_alertas')
            ->references('id')
            ->on('registro_de_delitos')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
