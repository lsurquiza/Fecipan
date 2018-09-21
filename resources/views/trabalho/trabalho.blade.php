@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<h1>
		Trabalhos Cadastrados na
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
	<a href="\trabalho\create\{{ $evento->id }}" class="btn btn-primary">
		<span class="glyphicon glyphicon-file"></span>
		Cadastrar Trabalho
	</a>
	@endif
	<br><br>

        <script>
$(document).ready( function () {
    $('#tableTrabalhos').DataTable(
		{
			"order": [[ 7, "desc" ]]
		} );
} );
		</script>
	<table id="tableTrabalhos" class="table table-condensed table-hover table-striped">
		<thead>
		  <tr>
			<th>Cod</th>
			<th>Trabalho</th>
			<th>Tipo</th>
			<th>Categoria</th>
			<th class='text-right'>Avaliações Feitas</th>
			<th class='text-right'>Estudantes</th>
			<th class='text-right'>Orientadores</th>
			<th class='text-right'>Média</th>
			<th class='text-right'>Ações</th>
		  </tr>
		</thead>
		<tbody>
		@foreach($evento->trabalhos as $t)
		  <tr>
			<td>{{ $t->cod }}</td>
			<td>{{ $t->titulo }}</td>
			<td>{{ $t->tipoTrabalho->nome }}</td>
			<td>{{ $t->categoria->descricao }}</td>
			<td class='text-right'>
				<a class="btn btn-primary btn-xs" href="\trabalho\avaliacoes\{{ $t->id }}" title="Visualizar avaliações para o trabalho {{ $t->cod }}">
					{{ $t->avaliacoes->where("notas_lancadas", 1)->count() }} de {{ $t->avaliacoes->count() }}
				</a>
			</td>
			<td class='text-right'>
				<a class="btn btn-primary btn-xs" href="\trabalho\estudantes\{{ $t->id }}" title="Visualizar estudantes do trabalho {{ $t->cod }}">
					{{ $t->estudantes->count() }}
				</a>
			</td>
			<td class='text-right'>
				<a class="btn btn-primary btn-xs" href="\trabalho\orientadores\{{ $t->id }}" title="Visualizar orientadores do trabalho {{ $t->cod }}">
					{{ $t->orientadores->count() }}
				</a>
			</td>
			<td class="text-right">
			<?php 
				$avaliacoes = $t->avaliacoes->where('notas_lancadas', 1)->count();
				$somatorio= 0;
				foreach ($t->avaliacoes->where('notas_lancadas', 1) as $a):
					foreach ($a->notas as $nota):
						$somatorio += $nota->valor * $nota->quesito->peso;
					endforeach;
				endforeach;
				$media = $avaliacoes == 0? "0": $somatorio/$avaliacoes;
				printf("<h5>%.2f</h5>", $media); 
			?>
			</td>
			<td>
			  <div class='btn-group'>
				  @if ($permissoes->alterar)
				  <a class='btn btn-primary btn-xs' href="/trabalho/update/{{$t->id}}" title="Alterar trabalho #{{$t->id}}"> 
					<span class="glyphicon glyphicon-pencil"></span>
				  </a>
				  @endif
				  @if ($permissoes->excluir)
				  <a class='btn btn-primary btn-xs' href="#" data-toggle="modal" data-target="#{{$t->id}}"title="Excluir trabalho #{{$t->id}}">
					<span class="glyphicon glyphicon-trash"></span>
				  </a>
				  @endif
			  </div>
			  <div id="{{$t->id}}" class="modal fade text-justify" role="dialog">
				  <div class="site-wrapper">
					<div class="modal-dialog">                
					  <div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								<span class="glyphicon glyphicon-alert"></span>
								Exclusão de Trabalho
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Deseja excluir o trabalho <strong>{{$t->id}} - {{$t->cod}}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
							<a href="/trabalho/delete/{{$t->id}}" class="btn btn-danger">Sim</a>
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
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento">
		Voltar
	  </a>
	</div>
@endif
@stop 