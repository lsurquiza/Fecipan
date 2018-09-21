@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>
			Associar Orientadores ao Trabalho {{ $trabalho->cod }}
		</h4>
		<p>{{ $trabalho->titulo }}</p>
	</div>
	<div class="panel-body">
	<form class="form-horizontal" action="/orientacao/create" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" />
		<fieldset>
		
	    @if (!$tem_orientador)
		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="orientador_id">Orientador</label>  

		  <div class="col-sm-8 col-md-6">
		  	<select id="orientador" name="orientador_id" data-placeholder="Selecione o orientador..." class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($orientadores as $orientador)
				<option value="{{ $orientador->id }}">{{ $orientador->instituicao->sigla }} - {{ $orientador->pessoa->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('orientador_id')}}</li>
				</div>
			@endif	
		  </div>
		</div>
		@endif
		
	    <div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="coorientadores">Coorientadores</label>  
		  <div class="col-sm-8 col-md-6">
		  	<select id="coorientadores" name="coorientadores[]" multiple data-placeholder="Selecione os coorientadores..." class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($orientadores as $orientador)
				<option value="{{ $orientador->id }}">{{ $orientador->instituicao->sigla }} - {{ $orientador->pessoa->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('orientadores')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-10">
		    <button class="btn btn-primary" type="submit">Registrar</button>
		    <a href="/trabalho/orientadores/{{ $trabalho->id }}" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>		

		</fieldset>
	</form>
	</div>
</div>

@stop