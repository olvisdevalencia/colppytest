<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests;
use Illuminate\Http\Request;


class EnterprisesController extends Controller
{
  /**
   *
   * Method to get a list of all enterprises
   * @param Request $request
   * @return JSON
   */
    public function getList(Request $request) {

      try {

        $enterprises  = Empresa::all();
        $response     = [];

        if ($enterprises) {

          $response = $enterprises;
        }

        return response()->JSON($response,200);

      } catch (\Exception $e) {

        return $e->getMessage();

      }


    }
}
