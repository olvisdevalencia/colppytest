<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(EmpresasTableSeeder::class);
        $this->call(ClientesTableSeeder::class);
        $this->call(FacturasTableSeeder::class);
        $this->call(ItemsFacturasTableSeeder::class);

        Model::reguard();
    }
}
