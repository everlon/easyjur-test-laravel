<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AgendasExport;

class AgendaController extends Controller
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
        // $agenda = Agenda::where("user_id", auth()->user()->id)->paginate(20);

        if (auth()->user()->can("visualizar")) {
            $agenda = Agenda::paginate(20);
        } else {
            $agenda = Agenda::where("user_id", auth()->user()->id)->paginate(
                20
            );
        }

        return view("layouts.agenda.index")->with("agendas", $agenda);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("layouts.agenda.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // EAP: Aqui ele irá pegar o ID do usuário logado para incluir na Tarefa.
        $input["user_id"] = auth()->user()->id;

        Agenda::create($input);
        return redirect("agenda")->with(
            "status",
            "Tarefa adicionada com sucesso!"
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $agenda = Agenda::find($id);
        // return view("layouts.agenda.show")->with("agenda", $agenda);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agenda = Agenda::find($id);
        return view("layouts.agenda.edit")->with("agenda", $agenda);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id); // EAP: Ele irá encontrar ou dar falha.
        $input = $request->all();

        // EAP: Necessário colocar o valor do checkbox para que possa ser salvo.
        if (!$request->has(["status"])) {
            $input["status"] = "Pendente";
        }

        if ($request->has(["status"]) and $input["status"] == "Concluído") {
            // $dataHoraAtual = new DateTime();
            $input["data_conclusao"] = date("Y-m-d H:i:s");
            // $dataHoraAtual->format("Y-m-d H:i:s");
        }

        // EAP: Atualizar os dados.
        $agenda->update($input);

        if ($request->has(["status", "nome"])) {
            return redirect("agenda")->with(
                "status",
                "Tarefa atualizada com sucesso!"
            );
        } elseif ($request->has("status")) {
            // EAP: Coloquei os valores no checkbox não ele não valida se tem ou não.
            return '
            <input name="status" value="Pendente" class="form-check-input" type="checkbox" role="switch" checked>
            <label class="form-check-label" hx-target="this.nextElementSibling">Concluído</label>';
        } else {
            // EAP: Coloquei os valores no checkbox não ele não valida se tem ou não.
            return '
            <input name="status" value="Concluído" class="form-check-input" type="checkbox" role="switch">
            <label class="form-check-label" hx-target="this.nextElementSibling">Pendente</label>';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Agenda::destroy($id);
        return redirect("agenda")->with(
            "status",
            "Tarefa excluída com sucesso!"
        );
    }

    public function exportacao($extensao)
    {
        $nome_arquivo = "agenda_easyjur";

        if ($extensao == "xlsx" or $extensao == "csv" or $extensao == "pdf") {
            $nome_arquivo .= "." . $extensao;
        } else {
            return redirect()->route("agenda.index");
        }

        return Excel::download(new AgendasExport(), $nome_arquivo);
    }
}
