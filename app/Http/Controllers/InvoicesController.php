<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Http\Requests;
use Illuminate\Http\Request;


class InvoicesController extends Controller
{
  /**
   *
   * Method to get a list of all invoices
   * @param Request $request
   * @return JSON
   */
    public function getList(Request $request) {

      try {

        $invoices = Factura::all();
        $response = [];

        if ($invoices) {
          foreach ($invoices as $k => $v) {

            $response[] = [
                          'id'         => $v->id,
                          'empresa'    => $v->empresa->RazonSocial,
                          'cliente'    => $v->cliente->Nombre,
                          'Subtotal'   => $v->Subtotal,
                          'IVA'        => $v->IVA,
                          'total'      => $v->total,
                          'created_at' => $v->created_at->format('Y-m-d')
                         ] ;

          }
        }

        return response()->JSON($response,200);

      } catch (\Exception $e) {

        return $e->getMessage();

      }


    }

    /**
     *
     * Method to create an invoice
     * @param Request $request
     * @return JSON
     */
      public function postCreate(Request $request) {

        try {

          $id_empresa     = $request->idEmpresa;
          $id_cliente     = $request->idCliente;
          $detail_list    = $request->detailList;

          $sub_total      = null;
          $iva            = null;
          $total          = null;

          $response       = ['success' => false];

          if (is_null($detail_list) || !$id_empresa || !$id_cliente) {
            return response()->JSON($response,200);
          }

          foreach ($detail_list as $k => $v) {

            $detail_list[$k]['sub_total'] = $v['qty'] * $v['amount'];
            $detail_list[$k]['iva']       = ($detail_list[$k]['sub_total'] * 25) /100;
            $detail_list[$k]['total']     = $detail_list[$k]['sub_total'] + $detail_list[$k]['iva'];

            $detail_full[$k]['nombreItem']       = $v['name'];
            $detail_full[$k]['cantidad']         = $v['qty'];
            $detail_full[$k]['precio_unitario']  = $v['amount'];
            $detail_full[$k]['idEmpresa']        = $id_empresa;

            $sub_total[] = $detail_list[$k]['sub_total'];
            $iva      [] = $detail_list[$k]['iva'];
            $total    [] = $detail_list[$k]['total'];

          }

          $sub_total = array_sum($sub_total);
          $iva       = array_sum($iva);
          $total     = array_sum($total);

          $invoice   =  new Factura();
          $invoice->idEmpresa = $id_empresa;
          $invoice->idCliente = $id_cliente;
          $invoice->Subtotal  = $sub_total;
          $invoice->IVA       = $iva;
          $invoice->total     = $total;
          $invoice->save();

          foreach ($detail_list as $k => $v) {

            $detail_full[$k]['idFactura']  = $invoice->id;
            $detail_full[$k]['created_at'] = $invoice->created_at;
          }

          $invoice->detalleFacturas()->attach($detail_full);
          $invoice->numero = $invoice->id;
          $invoice->save();

          $response = ['success' => true];

          return response()->JSON($response,200);

        } catch (\Exception $e) {

          return $e->getMessage();

        }


      }

    /**
     *
     * Method to get an invoice by id
     * @param Request $request
     * @return JSON
     */
      public function getInvoiceById(Request $request) {

        try {

          $invoice_id = $request->idFactura;

          $invoice             = Factura::find($invoice_id);

          $response['success'] = false;

          if ($invoice) {

            $enterprise = $invoice->empresa()->first();
            $client     = $invoice->cliente()->first();
            $details    = $invoice->detalles()->get();

            $response   = [
                'empresa'   => $enterprise,
                'cliente'   => $client,
                'factura'   => $invoice,
                'detalles'  => $details,
                'success'   => true
            ];

          }

          return response()->JSON($response,200);

        } catch (\Exception $e) {

          return $e->getMessage();

        }


    }

    /**
     *
     * Method to edit an invoice by id
     * @param Request $request
     * @return JSON
     */
      public function editInvoiceById(Request $request) {

        try {

          $invoice_id     = $request->invoiceId;
          $enterprise_id  = $request->enterpriseId;
          $newestList     = $request->newestList;
          $oldestList     = $request->oldestList;
          $deleteList     = $request->deleteList;

          $invoice        = Factura::find($invoice_id);

          $response['success'] = false;

          if (!$invoice || is_null($oldestList) ) {
            return response()->JSON($response,200);
          }

          $response['success'] = true;

          $sub_total      = null;
          $iva            = null;
          $total          = null;

          if ($deleteList) {

            $invoice->eliminarDetalles($deleteList);
          }

          if ($oldestList) {

            foreach ($oldestList as $k => $v) {

              $oldestList[$k]['sub_total'] = $v['cantidad'] * $v['precio_unitario'];
              $oldestList[$k]['iva']       = ($oldestList[$k]['sub_total'] * 25) /100;
              $oldestList[$k]['total']     = $oldestList[$k]['sub_total'] + $oldestList[$k]['iva'];

              $sub_total[] = $oldestList[$k]['sub_total'];
              $iva      [] = $oldestList[$k]['iva'];
              $total    [] = $oldestList[$k]['total'];

            }

          }

          if ($newestList) {

            foreach ($newestList as $k => $v) {

              $newestList[$k]['sub_total'] = $v['cantidad'] * $v['precio_unitario'];
              $newestList[$k]['iva']       = ($newestList[$k]['sub_total'] * 25) /100;
              $newestList[$k]['total']     = $newestList[$k]['sub_total'] + $newestList[$k]['iva'];

              $detail_full[$k]['nombreItem']       = $v['nombreItem'];
              $detail_full[$k]['cantidad']         = $v['cantidad'];
              $detail_full[$k]['precio_unitario']  = $v['precio_unitario'];
              $detail_full[$k]['idEmpresa']        = $enterprise_id;
              $detail_full[$k]['idFactura']        = $invoice->id;
              $detail_full[$k]['created_at']       = $invoice->created_at;

              $sub_total[] = $newestList[$k]['sub_total'];
              $iva      [] = $newestList[$k]['iva'];
              $total    [] = $newestList[$k]['total'];

            }
            $invoice->detalleFacturas()->attach($detail_full);
          }


          $sub_total = array_sum($sub_total);
          $iva       = array_sum($iva);
          $total     = array_sum($total);

          $invoice->Subtotal  = $sub_total;
          $invoice->IVA       = $iva;
          $invoice->total     = $total;

          $invoice->save();

          return response()->JSON($response,200);

        } catch (\Exception $e) {

          return $e->getMessage();

        }

    }
}
