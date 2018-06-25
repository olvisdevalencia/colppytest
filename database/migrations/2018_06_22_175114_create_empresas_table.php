<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //(id,Nombre,RazonSocial, CUIT. Cuit no se puederepetir en una existente)
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nombre');
            $table->string('RazonSocial');
            $table->string('CUIT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empresas');
    }
}
