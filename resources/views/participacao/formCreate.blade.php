@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>
			Associar Estudante ao Trabalho {{ $trabalho->cod }}
		</h4>
		<p>{{ $trabalho->titulo }}</p>
	</div>
	<div class="panel-body">
	<form class="form-horizontal" action="/participacao/create" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" />
		<fieldset>
		
		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="estudantes">Estudantes</label>  
		  <div class="col-sm-8 col-md-6">
		  	<select id="estudantes" name="estudantes[]" data-placeholder="Selecione os estudantes..." multiple class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($estudantes as $estudante)
				<option value="{{ $estudante->id }}">{{ $estudante->instituicao->sigla }} - {{ $estudante->pessoa->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('estudantes')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-10">
		    <button class="btn btn-primary" type="submit">Registrar</button>
		    <a href="/trabalho/estudantes/{{ $trabalho->id }}" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>		

		</fieldset>
	</form>
	</div>
</div>

@stop