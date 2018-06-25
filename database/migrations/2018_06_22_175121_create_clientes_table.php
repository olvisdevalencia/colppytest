<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Campos tabla cliente: id, Nombre, CUIT/CUIL, idEmpresa (FK a la empresa)
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nombre');
            $table->string('CUIT');
            $table->integer('idEmpresa')->unsigned()->index();
            $table->foreign('idEmpresa')->references('id')->on('empresas')->onDelete('cascade');
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
        Schema::drop('clientes');
    }
}
