@extends ('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar == true)
	<h1>Eventos</h1>
	<hr>
	@if ($permissoes->inserir == true)
	<a href="\evento\create" class="btn btn-primary">
		<span class="glyphicon glyphicon-file"></span>
		Cadastrar Evento
	</a><br><br>
	@endif
	<table id="table" class="table table-condensed table-hover table-striped">
	  <thead>
		<tr>
			<th>#</th>
			<th>Título</th>
			<th>Ano/Sem</th>
			<th>Tema</th>
			<th>Período</th>
			<th class='text-right'>Quesitos</th>
			<th class='text-right'>Trabalhos</th>
			<th class='text-right'>Ações</th>
		</tr>
	  </thead>
	  <tbody>
	@foreach($eventos as $e)
		<tr>
			<td>{{ $e->id }}</td>
			<td>{{ $e->titulo }}</td>
			<td>{{ $e->ano }}/{{ $e->semestre }}</td>
			<td>{{ $e->tema }}</td>
			<td>
				De {{ date('d/m/Y', strtotime($e->data_inicio)) }}
				até {{ date('d/m/Y', strtotime($e->data_fim)) }}
			</td>
			<td class='text-right'>
				<a class="btn btn-primary btn-sm" href="\evento\quesitos\{{ $e->id }}" title="Visualizar quesitos de avaliação da {{ $e->titulo }}">
					{{ $e->quesitos->count() }}
				</a>
			</td>
			<td class='text-right'>
				<a class="btn btn-primary btn-sm" href="\evento\trabalhos\{{ $e->id }}" title="Visualizar trabalhos da {{ $e->titulo }}">
					{{ $e->trabalhos->count() }}
				</a>
			</td>
			<td class='text-right'> 
			  <div class='btn-group'>
				  @if ($permissoes->alterar)
				  <a class='btn btn-primary btn-sm' href="/evento/update/{{$e->id}}" title="Alterar evento {{$e->titulo}}"> 
					<span class="glyphicon glyphicon-pencil"></span>
				  </a>
				  @endif
				  @if ($permissoes->excluir)
				  <a class='btn btn-primary btn-sm' href="#" data-toggle="modal" data-target="#{{$e->id}}"title="Excluir evento {{$e->titulo}}">
					<span class="glyphicon glyphicon-trash"></span>
				  </a>
				  @endif
				  <a class="btn btn-primary btn-sm" href="/ranking/{{ $e->id }}">
					Ranking
				  </a>
			  </div>
			  <div id="{{$e->id}}" class="modal fade text-justify" role="dialog">
				  <div class="site-wrapper">
					<div class="modal-dialog">                
					  <div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								<span class="glyphicon glyphicon-alert"></span>
								Exclusão de Evento
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Deseja excluir o evento <strong>{{$e->id}} - {{$e->titulo}}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
							<a href="/evento/delete/{{$e->id}}" class="btn btn-danger">Sim</a>
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
@stop 