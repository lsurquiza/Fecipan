@extends('layouts.app')

@section('conteudo')

@if ($permissoes->visualizar)
	<h1>Área</h1>
	<hr>
	@if ($permissoes->inserir)
	  <a href="/area/create" class="btn btn-primary"><span class="glyphicon glyphicon-file"></span> Cadastrar Área</a><br><br>
	@endif
	<table id="table" class="table table-striped table-hover">
	  <thead>
		<tr>
			<th>#</th>
			<th>Sigla</th>
			<th>Descrição</th>
			<th class="text-right">Ações</th>
		</tr>
	  </thead>
	  <tbody>
	@foreach($areas as $a)
		<tr>
			<td>{{ $a->id }}</td>
			<td>{{ $a->sigla }}</td>
			<td>{{ $a->area }}</td>
			<td class="text-right">
			  <div class="btn-group">
			  @if ($permissoes->alterar)
				  <a class="btn btn-sm btn-primary" href="/area/update/{{$a->id}}" title="Alterar área"><span class="glyphicon glyphicon-pencil"></span></a>
			  @endif
			  @if ($permissoes->excluir)
			    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#{{$a->id}}" title="Excluir área"><span class="glyphicon glyphicon-trash"></span></a>
			  @endif
			  </div>
				<div id="{{$a->id}}" class="modal fade text-justify" role="dialog">
				  <div class="site-wrapper">
					<div class="modal-dialog">                
					  <div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								<span class="glyphicon glyphicon-alert"></span>
								Exclusão de Área
							</h4>
						  </div>
						  
						  <div class="modal-body">
							<p>Confirma a exclusão da área <strong>{{ $a->id }} - {{ $a->area }}</strong>?</p>
						  </div>
						  
						  <div class="modal-footer">
							<a href="/area/delete/{{$a->id}}" class="btn btn-danger">Sim</a>
							<a href="/area" class="btn btn-info" data-dismiss="modal">Não</a>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </td>
			</td>
		</tr>
	  @endforeach
	  </tbody>
	</table>
@endif
@stop