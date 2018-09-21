@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Cadastro de Quesito para o Evento {{ $evento->nome }} {{ $evento->ano }}/{{ $evento->semestre }}</h4>
	</div>
	<div class="panel-body">
	<form class="form-horizontal" action="/quesito/create" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="hidden" name="evento_id" value="{{ $evento->id }}" />
		<fieldset>
		
		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="enunciado">Enunciado</label>  
		  <div class="col-sm-8 col-md-6">
		  	<input id="enunciado" name="enunciado" type="text" placeholder="Enunciado do Quesito" class="form-control input-md" value="{{ old('enunciado') }}">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('enunciado')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="peso">Peso</label>  
		  <div class="col-sm-3 col-md-2">
		  	<input id="peso" name="peso" type="number" min="0" placeholder="Peso do Quesito" class="form-control input-md" value="{{ old('peso') }}">
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('peso')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-10">
		    <button class="btn btn-primary" type="submit">Registrar</button>
		    <a href="/evento/quesitos/{{ $evento->id }}" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>		

		</fieldset>
	</form>
	</div>
</div>

@stop