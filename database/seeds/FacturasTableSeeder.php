<?php

use Illuminate\Database\Seeder;

class FacturasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('facturas')->insert([
          'id'          => 1,
          'numero'      => 1,
          'idEmpresa'   => 1,
          'idCliente'   => 1,
          'Subtotal'    => 32000,
          'IVA'         => 8000,
          'total'       => 40000,
          'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
      ]);
      DB::table('facturas')->insert([
          'id'          => 2,
          'numero'      => 2,
          'idEmpresa'   => 1,
          'idCliente'   => 2,
          'Subtotal'    => 480,
          'IVA'         => 120,
          'total'       => 600,
          'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
      ]);
    }
}
