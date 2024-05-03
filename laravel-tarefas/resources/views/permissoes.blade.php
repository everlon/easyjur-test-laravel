@extends('layouts.app')

@section('content')

<script src="https://unpkg.com/htmx.org@1.9.12"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb">
                {{--<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>--}}
                <li class="breadcrumb-item active" aria-current="page">{{ __('Permissões') }}</li>
              </ol>
            </nav>

            <div class="card">
                <div class="card-header">{{ __('Lista dos Usuários') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Contatos</th>
                                    <th>Datas</th>
                                    <th class="col-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($usuarios as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <b>E-Mail:</b><br>{{ $item->email }}<br><br>
                                        <b>Telefone:</b><br>{{ $item->telefone }}
                                    </td>
                                    <td>
                                        <b>Criação:</b><br>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y \à\s H:i \h\o\r\a\s') }}<br><br>
                                        <b>Atualização:</b><br> {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y \à\s H:i \h\o\r\a\s') }}
                                    </td>
                                    <td>
                                        <form hx-post="{{ route('update-permss') }}"
                                              hx-swap="outerHTML settle:3s"
                                              hx-target="#toast-{{ $item->id }}">
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <span id="toast-{{ $item->id }}"></span>
                                            @foreach($permissoes as $item_perm)
                                               	@csrf
                                                @method("PATCH")
                                                <div class="form-check form-switch">
                                                    <input name="check-permss-{{ $item->id }}-{{ $loop->iteration }}" class="form-check-input" type="checkbox" role="switch" {{ $item->can($item_perm->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ ucfirst($item_perm->name) }}</label>
                                                </div>
                                            @endforeach
                                            <input type="submit" value="Atualizar permissões" class="btn btn-outline-primary btn-sm">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
