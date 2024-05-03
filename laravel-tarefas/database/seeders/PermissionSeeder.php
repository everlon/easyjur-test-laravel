<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * EAP: Criando permissões por Spatie.
     */
    public function run()
    {
        // Permission::create(["name" => "administrador"]);
        // Permission::create(["name" => "visualizar"]);
        // Permission::create(["name" => "cadastrar"]);
        // Permission::create(["name" => "editar"]);
        // Permission::create(["name" => "apagar"]);
        // Permission::create(["name" => "imprimir"]);

        // $user = User::find(2);
        // $user->givePermissionTo([
        //     "visualizar",
        //     "cadastrar",
        //     "editar",
        //     "imprimir",
        // ]);
        // $user->revokePermissionTo("apagar");

        // $user = User::find(1);
        // $user->givePermissionTo("administrador");
        // $user->revokePermissionTo("visualizar");
    }
}
