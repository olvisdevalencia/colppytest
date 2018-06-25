<?php

use Illuminate\Database\Seeder;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            'id'          => 1,
            'Nombre'      => 'Colppy',
            'RazonSocial' => 'ALL ONLINE SOLUTIONS S.A.',
            'CUIT'        => '3712461221',
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
