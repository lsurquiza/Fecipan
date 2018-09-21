@extends('layouts.app')

@section('conteudo')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="glyphicon glyphicon-user"></span>
                        <small>FrEvO - IFMS</small>
                    </h1>
					<h4>
						Framework para Gerenciamento e Controle de Eventos do IFMS
					</h4>
                </div>

                <div class="panel-body">
                @if (Auth::check())
                    Olá, {{ Auth::user()->pessoa->nome }} ({{ Auth::user()->perfil->descricao }})
                @else
                    Você precisa estar logado para acessar as partes privadas do sistema
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
