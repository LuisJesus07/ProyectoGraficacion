<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permission list
        Permission::create(['name' => 'Administrar']);
        Permission::create(['name' => 'Visualizar']);
        Permission::create(['name' => 'Editar']);
        Permission::create(['name' => 'Agregar']);
        Permission::create(['name' => 'Eliminar']);

        //Admin
        $admin = Role::create(['name' => 'Administrador']);
        $admin->givePermissionTo([
            'Visualizar',
            'Editar',
            'Agregar',
            'Eliminar'
        ]);

        //Guest
        $guest = Role::create(['name' => 'Guest']);

        $guest->givePermissionTo([
            'Visualizar'
        ]);

        $usuarios = User::all();
        foreach($usuarios as $usuario){
        	$usuario->assignRole($usuario->role);
        }
    }
}
