@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<div class="panel panel-default">
	  <div class="panel-heading">
		<h3>Questionário de Avaliação</h3>
		<h4>
			<strong>Trabalho:</strong>
			{{ $avaliacao->trabalho->titulo }}
		</h4>
		<h4><strong>Código:</strong> {{ $avaliacao->trabalho->cod }}</h4>
		<h4><strong>Categoria:</strong> {{ $avaliacao->trabalho->categoria->descricao }}</h4>
		<h4><strong>Avaliador:</strong> {{ $avaliacao->avaliador->pessoa->nome }}</h4>
	  </div>
	  <div class="panel-body">
		<form class="form-horizontal" action="/avaliacao/notas" method="POST">
			<input class="hidden-print" type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input class="hidden-print" type="hidden" name="avaliacao_id" value="{{ $avaliacao->id }}" />
			  <div class="form-group">
				@foreach($avaliacao->trabalho->orientadores as $o)
				<div class="col-sm-offset-1 col-md-offset-1 col-sm-8 col-md-6">
					<b>{{ $o->pivot->tipo_orientacao == 1? "Orientador": "Coorientador" }}:</b> {{ $o->pessoa->nome }}<br>
				</div>
				@endforeach
				@foreach($avaliacao->trabalho->estudantes as $es)
				<div class="col-sm-offset-1 col-md-offset-1 col-sm-8 col-md-6">
					<b>Estudante:</b> {{ $es->pessoa->nome }}<br>
				</div>
				@endforeach
			  </div>
			  <?php $i = 1 ?>
			  @foreach ($avaliacao->notas as $n)
			  <hr>
			  <div class="form-group text-left">
		  	 	<div class="col-sm-offset-1 col-sm-6 col-md-offset-2 col-md-5"> 
					{{$i++}} - {{$n->quesito->enunciado}} 
					<strong class='text-info'>(Peso {{ $n->quesito->peso }})</strong>
		  	 	</div>
		  	 	<div class="col-sm-3 col-md-3"> 
		  	 	 	<input name="notas[{{ $n->id }}]" type="number" value="{{ is_null($n->valor)? "": $n->valor }}" min="0" max="10" step="0.1" class="form-control input-xs" placeholder="De 0.0 até 10.0" required>
		  	 	</div>
			  </div>
			  @endforeach
			  
			  <div class="form-group">
				<div class="col-sm-offset-1 col-md-offset-2 col-sm-10">
				  <button class="btn btn-primary" type="submit">Registrar</button>
				  <a href="/trabalho/avaliacoes/{{ $avaliacao->trabalho->id }}" class="btn btn-danger">Cancelar</a>
				</div>
			  </div>		
		</form>
	  </div>
	</div>
		<div class="text-center">
			<a href="javascript: window.print();" class="hidden-print btn btn-primary no-print" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
		</div>
@endif
@stop
