@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<h1><span class="glyphicon glyphicon-education"></span> Estudantes</h1>
	<h3>{{ $trabalho->cod }} - {{ $trabalho->titulo }}</h3>
	<h4>
		{{ $trabalho->evento->titulo }} 
		{{ $trabalho->evento->ano }}/{{ $trabalho->evento->semestre }}
	</h4>
	<p>{{ $trabalho->evento->tema }}</p>	
	<hr>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento/trabalhos/{{ $trabalho->evento_id }}">
		Voltar
	  </a>
	</div>
	@if ($permissoes->inserir == true)
	<a href="\participacao\create\{{ $trabalho->id }}" class="btn btn-primary">
		<span class="glyphicon glyphicon-file"></span>
		Cadastrar Estudantes
	</a>
	@endif
	<br><br>

	@foreach($trabalho->estudantes as $q)
		  <div class='panel panel-default'>
			<div class='panel-heading'>
			  <div class='row'>
			  <div class='col-sm-10'>
				<h4><strong>Estudante:</strong> {{ $q->pessoa->nome }}</h4>
			  </div>
			  <div class='btn-group col-sm-2'>
				  @if ($permissoes->excluir)
				  <a class='btn btn-primary btn-sm' href="#" data-toggle="modal" data-target="#{{$q->id}}"title="Excluir avaliacao #{{$q->id}}">
					<span class="glyphicon glyphicon-trash"></span>
				  </a>
				  @endif
			  </div>
			  </div>
			  <div id="{{$q->id}}" class="modal fade text-justify" role="dialog">
				  <div class="site-wrapper">
					<div class="modal-dialog">                
					  <div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								<span class="glyphicon glyphicon-alert"></span>
								Exclusão de Estudante
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Deseja excluir a participação do estudante <strong>{{$q->id}} - {{$q->pessoa->nome}}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
							<a href="/participacao/delete/{{$trabalho->id}}/{{$q->id}}" class="btn btn-danger">Sim</a>
							<button class="btn btn-info" data-dismiss="modal">Não</button>
						</div>
					  </div>
					</div>
				  </div>
			  </div>
			</div>
			<div class='panel-body'>
				<div><strong>Escola:</strong> {{ $q->instituicao->sigla }} - {{ $q->instituicao->nome }}</div>
				<div><strong>Cidade:</strong> {{ $q->instituicao->cidade }}</div>
			</div>
		  </div>
	  @endforeach
@endif
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento/trabalhos/{{ $trabalho->evento_id }}">
		Voltar
	  </a>
	</div>
@stop 