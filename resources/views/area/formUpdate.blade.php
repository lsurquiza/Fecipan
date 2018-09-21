@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Editar a Área #{{ $area->id }}</h4>
	</div>
	<div class="panel-body">
	<form class="form-horizontal" action="/area/update" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="hidden" name="area_id" value="{{$area->id}}" />
		<fieldset>
		<div class="form-group">
		  <label class="col-md-3 col-sm-4 control-label" for="sigla">Sigla</label>  
		  <div class="col-md-3 col-sm-4">
			<input id="sigla" name="sigla" type="text" value="{{$area->sigla}}" placeholder="Digite a sigla da área" class="form-control input-md">
			  <!-- DIV PARA MOSTRAR OS ERROS -->
			 @if(count($errors)>0)
				<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('sigla')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-3 col-sm-4 control-label" for="text">Descrição</label>  
		  <div class="col-md-6 col-sm-8">
		  	<input id="area" name="area" type="text" value="{{$area->area}}" placeholder="Digite a descrição da área" class="form-control input-md">
		  	  <!-- DIV PARA MOSTRAR OS ERROS -->
		  	 @if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('area')}}</li>
				</div>
			@endif	
		  </div>
		</div>
		
		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-6 col-md-6">
		    <button class="btn btn-primary" type="submit">Editar</button>
		    <a href="/area" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>			
	</form>
	</div>
</div>
@stop