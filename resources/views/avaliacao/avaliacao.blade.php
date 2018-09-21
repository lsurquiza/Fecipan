@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<h1><span class="glyphicon glyphicon-education"></span> Avaliações</h1>
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
	<a href="\avaliacao\create\{{ $trabalho->id }}" class="btn btn-primary">
		<span class="glyphicon glyphicon-file"></span>
		Cadastrar Avaliadores
	</a>
	@endif
	<br><br>

	<?php $somatorio = 0 ?>
	<?php $num_avaliacoes = 0 ?>
	<?php 
		# Ordena as avaliações pelos nomes dos avaliadores
		$avaliacoes = $trabalho->avaliacoes->sortBy(function($avaliacao, $key){
			return ($avaliacao->avaliador->pessoa->nome);
		});	
	?>
	@foreach($avaliacoes as $q)	
		  <div class='panel panel-{{ $q->notas_lancadas? "success": "danger" }}'>
			<div class='panel-heading'>
			  <div class='row'>
			  <div class='col-sm-9'>
				<h4><strong>Avaliador:</strong> {{ $q->avaliador->pessoa->nome }}</h4>
				<div><strong>Área:</strong> {{ $q->avaliador->area }}</div>
			  </div>
			  <div class='btn-group col-sm-3'>
				  @if ($permissoes->alterar)
				  <a class='btn btn-{{ $q->notas_lancadas? "success": "danger" }} btn-sm' href="/avaliacao/notas/{{ $q->id }}" title="Lançar notas">
					<span class="glyphicon glyphicon-pencil"></span>
					Lançar Notas
				  </a>
				  @endif
				  @if ($permissoes->excluir)
				  <a class='btn btn-{{ $q->notas_lancadas? "success": "danger" }} btn-sm' href="#" data-toggle="modal" data-target="#{{$q->id}}"title="Excluir avaliacao #{{$q->id}}">
					<span class="glyphicon glyphicon-trash"></span>
				  </a>
				  @endif
				  <button class='btn btn-{{ $q->notas_lancadas? "success": "danger" }} btn-sm' data-toggle="collapse" data-target="#table_{{$q->id}}" title="Visualizar notas">+</button>
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
								Exclusão de Avaliação
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Deseja excluir as notas do avaliador <strong>{{$q->id}} - {{$q->avaliador->pessoa->nome}}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
							<a href="/avaliacao/delete/{{$q->id}}" class="btn btn-danger">Sim</a>
							<button class="btn btn-info" data-dismiss="modal">Não</button>
						</div>
					  </div>
					</div>
				  </div>
			  </div>
			</div>
			<div class='panel-body collapse' id="table_{{$q->id}}"  >
			<table class="table table-condensed table-hover table-striped">
				<caption>Notas</caption>
				<tr>
					<th>#</th>
					<th>Quesito</th>
					<th class='text-right'>Peso</th>
					<th class='text-right'>Valor</th>
					<th class='text-right'>Pontuação</th>
				</tr>
				<?php $subtotal = 0 ?>
				<?php $i = 1 ?>
			@foreach ($q->notas as $nota)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $nota->quesito->enunciado }}</td>
					<td class='text-right'><?php printf("%.1f", $nota->quesito->peso) ?></td>
					<td class='text-right'><?php printf(is_null($nota->valor)? "nulo":"%.1f", $nota->valor)  ?></td>
					<td class='text-right'><?php printf(is_null($nota->valor)? "nulo":"%.1f", $nota->quesito->peso * $nota->valor) ?></td>
				</tr>
				<?php $subtotal += $nota->quesito->peso * $nota->valor ?>
			@endforeach
			</table>
			</div>
			<div class='panel-footer'>
				<div class="text-right">
					@if ($q->notas_lancadas == true)
						<h4>Somatório da notas lançadas: <?php printf("%.2f", $subtotal) ?></h4>
						<?php $somatorio += $subtotal ?>
						<?php $num_avaliacoes++ ?>
					@else
						<h4>Ainda não avaliado</h4>
					@endif
				</div>
			</div>
		  </div>
	  @endforeach
	  <div class='alert alert-info'>
		<h3>Número de Avaliações Lançadas: {{ $num_avaliacoes }} de {{ $trabalho->avaliacoes->count() }}</h3>
		<h4><?php printf("Média Geral: %.2f", $num_avaliacoes >0 ? $somatorio/$num_avaliacoes: 0) ?></h4>
	  </div>
	<div class='text-right'>
	  <a class='btn btn-primary btn-sm' href="/evento/trabalhos/{{ $trabalho->evento_id }}">
		Voltar
	  </a>
	</div>
@endif
@stop 