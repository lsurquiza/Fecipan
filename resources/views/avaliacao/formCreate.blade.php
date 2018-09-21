@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>
			Associar Avaliadores ao Trabalho {{ $trabalho->cod }}
		</h4>
		<p>{{ $trabalho->titulo }}</p>
	</div>
	<div class="panel-body">
	<form class="form-horizontal" action="/avaliacao/create" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" />
		<fieldset>
		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="avaliadores">Avaliadores</label>  

		  <div class="col-sm-8 col-md-6">
		  	<select id="avaliadores" name="avaliadores[]" data-placeholder="Selecione os avaliadores..." multiple class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($avaliadores as $avaliador)
				<option value="{{ $avaliador->id }}">{{ $avaliador->pessoa->nome }} - {{ $avaliador->area }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('avaliadores')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-10">
		    <button class="btn btn-primary" type="submit">Registrar</button>
		    <a href="/trabalho/avaliacoes/{{ $trabalho->id }}" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>		

		</fieldset>
	</form>
	</div>
</div>

@stop