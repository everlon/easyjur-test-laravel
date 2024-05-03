<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PhpParser\Node\Stmt\If_;
use Spatie\Permission\Models\Permission;

class PermissaoController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);

        if ($user->can("administrador")) {
            // Usuário terá permissão para visualizar essa tela.
            $usuarios = User::all();
            $permissoes = Permission::all();

            return view("permissoes")
                ->with("usuarios", $usuarios)
                ->with("permissoes", $permissoes);
        }
        return redirect("agenda")->with(
            "status",
            "Você não tem permissão para editar as permissões dos usuários."
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Pegar os valores dos Checks.
        $input = $request->all();

        // Encontrar o usuário pelo ID
        $user = User::find($input["id"]);

        // SEGURANÇA EXTREMA: Verificar se o usuário foi encontrado.
        if (!$user) {
            return redirect()
                ->route("permissao")
                ->with("status", "Usuário não encontrado.");
        }

        // Remover todas as permissões para atualizar.
        $user->syncPermissions([]);

        // Mapear os campos de permissão enviados para seus nomes correspondentes.
        $permissions = [
            "check-permss-" . $input["id"] . "-1" => "visualizar",
            "check-permss-" . $input["id"] . "-2" => "cadastrar",
            "check-permss-" . $input["id"] . "-3" => "editar",
            "check-permss-" . $input["id"] . "-4" => "apagar",
            "check-permss-" . $input["id"] . "-5" => "imprimir",
            "check-permss-" . $input["id"] . "-6" => "administrador",
        ];

        /*
        $permissions_new = [];
        foreach ($input as $key => $value) {
            if (array_key_exists($key, $permissions)) {
                array_push($permissions_new, $key);
            }
        }
        $permissions_new = array_map(function ($permissions_new) use (
            $permissions
        ) {
            return $permissions[$permissions_new];
        }, $permissions_new);

        foreach ($permissions_new as $string) {
            $user->givePermissionTo($string);
        }
        */

        // Filtrar as permissões selecionadas
        $permissionsSelected = array_filter(
            $permissions,
            function ($key) use ($input) {
                return isset($input[$key]) && $input[$key] === "on";
            },
            ARRAY_FILTER_USE_KEY
        );

        // Atribuir as permissões selecionadas ao usuário
        $user->givePermissionTo(array_values($permissionsSelected));

        return '<span class="badge text-bg-success">Permissões atualizadas com sucesso!</span>';
    }
}
