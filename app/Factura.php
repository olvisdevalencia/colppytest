<?php

namespace App;

use App\DetalleFacturas;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{

 /**
  * Relation with Empresa
  */
  public function empresa()
  {

    return $this->belongsTo('App\Empresa','idEmpresa');

  }

  /**
   * Relation with Cliente
   */
  public function cliente()
  {

      return $this->belongsTo('App\Cliente','idCliente');

  }
  /**
   * Pivot method to inset and update detalle_facturas
   */
  public function detalleFacturas() {
      return $this->belongsToMany('App\DetalleFacturas','detalle_facturas','idFactura','idEmpresa');
  }

  /**
   * method to get all detail of an invoice
   */
  public function detalles() {

      return $this->join('detalle_facturas', 'detalle_facturas.idFactura', '=', 'facturas.id')
                  ->where('detalle_facturas.idFactura', $this->id)
                  ->select('detalle_facturas.*');
  }

  /**
   * method to delete an detail of an invoice by id
   * @param array $ids
   */
  public function eliminarDetalles($ids) {

      return DetalleFacturas::whereIn('id', $ids)->delete();
  }

}
