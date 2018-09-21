@extends('layouts.app')

@section('conteudo')

	<h1>Avaliador: {{ $avaliador->pessoa->nome }} - {{ $avaliador->area }}</h1>
	<h4>{{ $avaliador->instituicao->sigla }} - {{ $avaliador->instituicao->nome }}</h4>
	<div>Trabalhos Cadastrados</div>
	<hr>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/pessoa/avaliadores">
		Voltar
	  </a>
	</div><br><br>

	<table id="table" class="table table-condensed table-hover table-striped">
		<thead>
		  <tr>
			<th>ID</th>
			<th>Evento</th>
			<th>Código do Trabalho</th>
			<th>Titulo</th>
			<th>Tipo de Trabalho</th>
			<th>Área</th>
			<th>Categoria</th>
		  </tr>
		</thead>
		<tbody>
	@foreach($avaliador->avaliacoes as $t)
		  <tr>
			<td>{{ $t->trabalho->id }}</td>
			<td>{{ $t->trabalho->evento->ano }}/{{ $t->trabalho->evento->semestre }} {{ $t->trabalho->evento->titulo }}</td>
			<td>{{ $t->trabalho->cod }}</td>
			<td>{{ $t->trabalho->titulo }}</td>
			<td>{{ $t->trabalho->tipoTrabalho->nome }}</td>
			<td>{{ $t->trabalho->area->area }}</td>
			<td>{{ $t->trabalho->categoria->descricao }}</td>
		  </tr>
	  @endforeach
		</tbody>
	</table>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/pessoa/avaliadores">
		Voltar
	  </a>
	</div>
@stop 