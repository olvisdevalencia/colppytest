<?php

use Illuminate\Database\Seeder;

class ItemsFacturasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('detalle_facturas')->insert([
          'id'              => 1,
          'idFactura'       => 1,
          'nombreItem'      => 'Item test numero 1',
          'cantidad'        => 1,
          'precio_unitario' => '10666,6666',
          'idEmpresa'       => 1,
          'created_at'      => \Carbon\Carbon::now()->toDateTimeString(),
      ]);

      DB::table('detalle_facturas')->insert([
          'id'              => 2,
          'idFactura'       => 1,
          'nombreItem'      => 'Item test numero 2',
          'cantidad'        => 1,
          'precio_unitario' => '10666,6666',
          'idEmpresa'       => 1,
          'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
      ]);

      DB::table('detalle_facturas')->insert([
          'id'              => 3,
          'idFactura'       => 1,
          'nombreItem'      => 'Item test numero 3',
          'cantidad'        => 1,
          'precio_unitario' => '10666,6666',
          'idEmpresa'       => 1,
          'created_at'      => \Carbon\Carbon::now()->toDateTimeString(),
      ]);

      DB::table('detalle_facturas')->insert([
          'id'              => 4,
          'idFactura'       => 2,
          'nombreItem'      => 'Item test numero uno',
          'cantidad'        => 1,
          'precio_unitario' => '240',
          'idEmpresa'       => 1,
          'created_at'      => \Carbon\Carbon::now()->toDateTimeString(),
      ]);

      DB::table('detalle_facturas')->insert([
          'id'              => 5,
          'idFactura'       => 2,
          'nombreItem'      => 'Item test numero dos',
          'cantidad'        => 1,
          'precio_unitario' => '240',
          'idEmpresa'       => 1,
          'created_at'      => \Carbon\Carbon::now()->toDateTimeString(),
      ]);
    }
}
