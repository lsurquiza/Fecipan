@extends ('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar == true)
	<h1>Tipos de Trabalho</h1>
	<hr>
	@if ($permissoes->inserir == true)
	<a href="\tipoTrabalho\create" class="btn btn-primary">
		<span class="glyphicon glyphicon-file"></span>
		Cadastrar Tipo
	</a><br><br>
	@endif
	<table id="table" class="table table-striped table-hover">
	  <thead>
		<tr>
			<th>#</th>
			<th>Nome</th>
			<th>Ações</th>
		</tr>
	  </thead>
	  <tbody>
	  @foreach($tiposTrabalho as $t)
		<tr>
			<td>{{ $t->id }}</td>
			<td>{{ $t->nome }}</td>
			<td> 
			  <div class='btn-group'>
				  @if ($permissoes->alterar)
				  <a class='btn btn-primary btn-sm' href="/tipoTrabalho/update/{{$t->id}}" title="Alterar tipo {{ $t->nome }}"> 
					<span class="glyphicon glyphicon-pencil"></span>
				  </a>
				  @endif
				  @if ($permissoes->excluir)
				  <a class='btn btn-primary btn-sm' href="#" data-toggle="modal" data-target="#{{ $t->id }}"title="Excluir tipo {{ $t->nome }}">
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
								Exclusão de Tipo de Trabalho
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Deseja excluir o tipo <strong>{{$t->id}} - {{$t->nome}}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
							<a href="/tipoTrabalho/delete/{{$t->id}}" class="btn btn-danger">Sim</a>
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