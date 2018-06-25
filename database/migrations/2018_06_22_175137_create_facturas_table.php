<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Campos Tabla Factura: id, número, idEmpresa, idCliente, Subtotal, IVA
        (21%), Total.*/
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unsigned()->index();
            $table->integer('idEmpresa')->unsigned()->index();
            $table->foreign('idEmpresa')->references('id')->on('empresas');
            $table->integer('idCliente')->unsigned()->index();
            $table->foreign('idCliente')->references('id')->on('clientes');
            $table->string('Subtotal');
            $table->string('IVA');
            $table->string('total');
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
        Schema::drop('facturas');
    }
}
