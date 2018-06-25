<?php

use Illuminate\Database\Seeder;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('clientes')->insert([
          'id'          => 1,
          'Nombre'      => 'AVENIDA COMPRAS S.A.',
          'CUIT'        => '30714144649',
          'idEmpresa'   => 1,
          'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
      ]);

      DB::table('clientes')->insert([
          'id'          => 2,
          'Nombre'      => 'FC BOLA S.R.L.',
          'CUIT'        => '30714757519',
          'idEmpresa'   => 1,
          'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
      ]);
    }
}
