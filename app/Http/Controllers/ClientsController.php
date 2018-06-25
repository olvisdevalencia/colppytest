<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Http\Requests;
use Illuminate\Http\Request;


class ClientsController extends Controller
{
  /**
   *
   * Method to get a list of all clients
   * @param Request $request
   * @return JSON
   */
    public function getList(Request $request) {

      try {

        $id_empresa = isset($request->idEmpresa) ? $request->idEmpresa : null;

        $clients    = Cliente::where('idEmpresa', $id_empresa)->get();
        $response   = [];

        if ($clients) {

          $response = $clients;

        }

        return response()->JSON($response,200);

      } catch (\Exception $e) {

        return $e->getMessage();

      }


    }
}
