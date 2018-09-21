@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<h1>
		Quesitos de Avaliação para a
		{{ $evento->titulo }} {{ $evento->ano }}/{{ $evento->semestre }}
	</h1>
	<p>
		{{ $evento->tema }}
	</p>
	<hr>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>
	@if ($permissoes->inserir == true)
	<a href="\quesito\create\{{ $evento->id }}" class="btn btn-primary">
		<span class="glyphicon glyphicon-file"></span>
		Cadastrar Quesito
	</a>
	@endif
	<br><br>

	<table id="table" class="table table-condensed table-hover table-striped">
		<thead>
		  <tr>
			<th>ID</th>
			<th>Enunciado</th>
			<th class="text-right">Peso</th>
			<th>Ações</th>
		  </tr>
		</thead>
		<tbody>
		@foreach($evento->quesitos as $q)
		  <tr>
			<td>{{ $q->id }}</td>
			<td>{{ $q->enunciado }}</td>
			<td class="text-right">{{ $q->peso }}</td>
			<td> 
			  <div class='btn-group'>
				  @if ($permissoes->alterar)
				  <a class='btn btn-primary btn-sm' href="/quesito/update/{{$q->id}}" title="Alterar quesito #{{$q->id}}"> 
					<span class="glyphicon glyphicon-pencil"></span>
				  </a>
				  @endif
				  @if ($permissoes->excluir)
				  <a class='btn btn-primary btn-sm' href="#" data-toggle="modal" data-target="#{{$q->id}}"title="Excluir quesito #{{$q->id}}">
					<span class="glyphicon glyphicon-trash"></span>
				  </a>
				  @endif
			  </div>
			  <div id="{{$q->id}}" class="modal fade text-justify" role="dialog">
				  <div class="site-wrapper">
					<div class="modal-dialog">                
					  <div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								<span class="glyphicon glyphicon-alert"></span>
								Exclusão de Quesito
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Deseja excluir o quesito <strong>{{$q->id}} - {{$q->enunciado}}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
							<a href="/quesito/delete/{{$q->id}}" class="btn btn-danger">Sim</a>
							<button class="btn btn-info" data-dismiss="modal">Não</button>
						</div>
					  </div>
					</div>
				  </div>
			  </div>
			</td>
		  </tr>
		@endforeach
		</tbody>
	</table>
@endif
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>
@stop 