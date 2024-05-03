@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb">

                <li class="breadcrumb-item active" aria-current="page">Home</li>
              </ol>
            </nav>

            <div class="card">
                <div class="card-header">{{ __('Painel') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (auth()->check())
                        Olá {{ auth()->user()->name }}!
                    @endif

                    {{-- __('Você esta logado(a)!') --}}

                    <hr>
                    <p>Você poderá:
                        @foreach($permissoes as $permissao)
                            @can($permissao)
                                <span>{{ ucfirst($permissao) }} </span>
                            @endcan
                        @endforeach
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
