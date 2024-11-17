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
        Schema::create('registro_de_delitos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_users');
            $table->unsignedBigInteger('fk_tipoDelito');
            $table->unsignedBigInteger('fk_objetoRobado');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedBigInteger('fk_ubicacion');
            $table->string('detalles', 200)->nullable();

            //índices
            $table->index('fk_users', 'fk_users_registroDelito');
            $table->index('fk_tipoDelito', 'fk_tipoDelito_registroDelito');
            $table->index('fk_objetoRobado', 'fk_objetoRobado_registroDelito');
            $table->index('fk_ubicacion', 'fk_localidad_registroDelito');

            //Llaves foráneas
            $table->foreign('fk_users', 'fk_users_registroDelito')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('fk_tipoDelito', 'fk_delitos_registroDelito')
            ->references('id')
            ->on('delitos')
            ->onDelete('cascade');

            $table->foreign('fk_objetoRobado', 'fk_objetoRobado_registroDelito')
            ->references('id')
            ->on('objeto_robado')
            ->onDelete('cascade');

            $table->foreign('fk_ubicacion', 'fk_localidad_registroDelito')
            ->references('id')
            ->on('localidad')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_de_delitos');
    }
};
