@extends('layouts.app')

@section('content')

<script src="https://unpkg.com/htmx.org@1.9.12"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb">
                {{--<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>--}}
                <li class="breadcrumb-item active" aria-current="page">{{ __('Agenda') }}</li>
              </ol>
            </nav>

            <div class="card">
                <div class="card-header">{{ __('Lista das Tarefas') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col">
                            @can('cadastrar')
                            <button
                                hx-get="{{ route('agenda.create') }}"
                                hx-target="#modals-here"
                                hx-trigger="click"
                                data-bs-toggle="modal"
                                data-bs-target="#modals-here"
                                class="btn btn-success btn-sm">
                                    Adicionar nova Tarefa
                            </button>
                            @else
                            <button class="btn btn-success btn-sm" disabled> Adicionar nova Tarefa </button>
                            @endcan
                        </div>
                        <div class="col text-end">
                            @can('imprimir')
                            <a href="{{ route('exporta-excel', ['extensao' => 'pdf']) }}" class="btn btn-primary btn-sm">
                                Relatório em PDF
                            </a>
                            <a href="{{ route('exporta-excel', ['extensao' => 'xlsx']) }}" class="btn btn-primary btn-sm">
                                Relatório em Excel
                            </a>
                            <a href="{{ route('exporta-excel', ['extensao' => 'csv']) }}" class="btn btn-primary btn-sm">
                                Relatório em CSV
                            </a>
                            @else
                            <a href="#" class="btn btn-primary btn-sm disabled">
                                Relatório em PDF
                            </a>
                            <a href="#" class="btn btn-primary btn-sm disabled">
                                Relatório em Excel
                            </a>
                            <a href="#" class="btn btn-primary btn-sm disabled">
                                Relatório em CSV
                            </a>
                            @endcan
                        </div>
                    </div>
                    <br/>


                    <div class="table-responsive">
                        @if (count($agendas) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @can('visualizar')
                                    <th>Nome do Usuário</th>
                                    @endcan
                                    <th class="col-2">Nome da Tarefa</th>
                                    <th>Descrição da Tarefa</th>
                                    <th class="col-2">Data de Criação</th>
                                    <th class="col-2">Data de Conclusão</th>
                                    <th>Status</th>
                                    <th class="col-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($agendas as $item)
                                <tr id="tarefa-{{ $item->id }}">
                                    <td {{ $item->status == 'Concluído' ? "class=text-success" : "" }}>{{ $loop->iteration }}</td>
                                    @can('visualizar')
                                    <td {{ $item->status == 'Concluído' ? "class=text-success" : "" }}>{{ Auth::user()->name }}</td>
                                    @endcan
                                    <td {{ $item->status == 'Concluído' ? "class=text-success" : "" }}>{{ $item->nome }}</td>
                                    <td {{ $item->status == 'Concluído' ? "class=text-success" : "" }}>{{ $item->descricao }}</td>
                                    <td {{ $item->status == 'Concluído' ? "class=text-success" : "" }}>{{-- Formatando a data mais humanizada --}}
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y \à\s H:i \h\o\r\a\s') }}
                                    </td>
                                    <td {{ $item->status == 'Concluído' ? "class=text-success" : "" }}>
                                        @if ($item->data_conclusao)
                                            {{ \Carbon\Carbon::parse($item->data_conclusao)->format('d/m/Y \à\s H:i \h\o\r\a\s') }}
                                        @else
                                            <span class="badge text-bg-danger">Ainda não concluído</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $item->user_id == Auth::user()->id )
                                        <form style="display: inline;">
                                           	@csrf
                                            @method("PATCH")
                                            <div class="form-check form-switch" hx-post="{{ url('/agenda/' . $item->id) }}">
                                                <input name="status" value="{{ $item->status == 'Concluído' ? 'Pendente' : 'Concluído' }}" class="form-check-input" type="checkbox" role="switch" id="statusCheckbox-{{ $item->id }}" {{ $item->status == 'Concluído' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusCheckbox-{{ $item->id }}" hx-target="this.nextElementSibling">{{ $item->status }}</label>
                                            </div>
                                        </form>
                                        @else
                                            <p class="badge text-bg-warning text-wrap" style="width: 6rem;">
                                                Desabilitado</p>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        @can('editar')
                                        <button
                                            hx-get="{{ url('agenda/' . $item->id . '/edit') }}"
                                            hx-target="#modals-here"
                                            hx-trigger="click"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modals-here"
                                            class="btn btn-primary btn-sm">
                                                Editar
                                        </button>
                                        @else
                                        <button class="btn btn-primary btn-sm" disabled> Editar </button>
                                        @endcan

                                        @can('apagar')
                                        <form id="delete-form-{{ $item->id }}" action="{{ url('/agenda/' . $item->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button onclick="event.preventDefault();
                                                if(confirm('Tem certeza de que deseja apagar este item?')) {
                                                    document.getElementById('delete-form-{{ $item->id }}').submit(); }"
                                                class="btn btn-danger btn-sm">
                                            Apagar
                                        </button>
                                        @else
                                        <button class="btn btn-danger btn-sm" disabled> Apagar </button>
                                        @endcan

                                        {{--
                                        Token não está passando para o method DELETE.
                                        <form style="display: inline;">
                                           	@csrf
                                            @method('DELETE')
                                           	<button
                                                hx-delete="{{ url('/agenda/' . $item->id) }}"
                                                hx-confirm="Tem certeza de que deseja apagar este item?"
                                                hx-swap="outerHTML swap:1s"
                                                class="btn btn-danger btn-sm">
                                                    Apagar
                                            </button>
                                        </form>
                                        --}}
                                    </td>
                                </tr>
                            @endforeach

                                {{--
                                    <tr id="replaceMe">
                                        <td>
                                            <button class='btn' hx-get="{{ $agendas->previousPageUrl() }}"
                                                                hx-target="#replaceMe"
                                                                hx-swap="outerHTML">
                                                Veja mais...
                                            </button>
                                        </td>
                                    </tr>
                                --}}

                            </tbody>
                        </table>

                        @if ( $agendas->lastPage() > 1)
                        <nav class="mt-4 mb-4 mb-md-0">
                            <ul class="pagination pagination-sm justify-content-center">
                                @if ( $agendas->previousPageUrl() )
                                    <li class="page-item"><a class="page-link" href="{{ $agendas->previousPageUrl() }}">&laquo;</a></li>
                                @endif

                                @for($i = 1; $i <= $agendas->lastPage(); $i++)
                                    <li class="page-item {{ $agendas->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $agendas->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ( $agendas->nextPageUrl() )
                                    <li class="page-item"><a class="page-link" href="{{ $agendas->nextPageUrl() }}">&raquo;</a></li>
                                @endif
                            </ul>
                        </nav>
                        @endif


                        @else
                        <p class="text-center">Ainda não foram cadastradas nenhuma tarefa. <a href="{{ route('agenda.create') }}">Quer cadastrar uma nova?</a></p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para inclusão de Tarefa usando HTMX --}}
<div id="modals-here" class="modal modal-blur fade" style="display: none" aria-hidden="false" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content"></div>
    </div>
</div>

@endsection
