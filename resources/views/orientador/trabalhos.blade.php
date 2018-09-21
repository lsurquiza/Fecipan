@extends('layouts.app')

@section('conteudo')

	<h1>Orientador: {{ $orientador->pessoa->nome }}</h1>
	<h4>{{ $orientador->instituicao->sigla }} - {{ $orientador->instituicao->nome }}</h4>
	<div>Trabalhos Cadastrados</div>
	<hr>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/pessoa/orientadores">
		Voltar
	  </a>
	</div><br><br>

	<table id="table" class="table table-condensed table-hover table-striped">
		<thead>
		  <tr>
			<th>ID</th>
			<th>Código do Trabalho</th>
			<th>Evento</th>
			<th>Titulo</th>
			<th>Tipo de Trabalho</th>
			<th>Área</th>
			<th>Categoria</th>
		  </tr>
		</thead>
		<tbody>
		@foreach($orientador->trabalhos as $t)
		  <tr>
			<td>{{ $t->id }}</td>
			<td>{{ $t->cod }}</td>
			<td>{{ $t->evento->ano }}/{{ $t->evento->semestre }} {{ $t->evento->titulo }}</td>
			<td>{{ $t->titulo }}</td>
			<td>{{ $t->tipoTrabalho->nome }}</td>
			<td>{{ $t->area->area }}</td>
			<td>{{ $t->categoria->descricao }}</td>
		  </tr>
		@endforeach
		</tbody>
	</table>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/pessoa/orientadores">
		Voltar
	  </a>
	</div>
@stop 