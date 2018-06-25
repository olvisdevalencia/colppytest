<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      /*
      Campos tabla detalle FC (Opcional). id, idFactura, idItem, nombreItem,
      Cantidad, precio unitario, idEmpresa.*/
        Schema::create('detalle_facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idFactura')->unsigned()->index();
            $table->foreign('idFactura')->references('id')->on('facturas');
            $table->string('nombreItem');
            $table->integer('cantidad');
            $table->float('precio_unitario')->default(0);
            $table->integer('idEmpresa')->unsigned()->index();
            $table->foreign('idEmpresa')->references('id')->on('empresas');
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
        Schema::drop('detalle_facturas');
    }
}
