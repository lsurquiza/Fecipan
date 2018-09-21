@extends('layouts.app')

@section('conteudo')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>
			Cadastrar Trabalho na {{ $evento->titulo }}
		</h4>
		<p>{{ $evento->tema }}</p>
	</div>
	<div class="panel-body">
	<form class="form-horizontal" action="/trabalho/create" method="POST">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="hidden" name="evento_id" value="{{ $evento->id }}" />
		<fieldset>
	    <div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="categoria_id">Categoria</label>  

		  <div class="col-sm-6 col-md-4">
		  	<select id="categoria_id" name="categoria_id" data-placeholder="Escolha a categoria" class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($categorias as $categoria)
				<option value="{{ $categoria->id }}">{{ $categoria->descricao }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('categoria_id')}}</li>
				</div>
			@endif	
		  </div>
		</div>

	    <div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="tipo_trabalho_id">Tipo</label>  

		  <div class="col-sm-8 col-md-6">
		  	<select id="tipo_trabalho_id" name="tipo_trabalho_id" data-placeholder="Escolha o tipo" class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($tiposTrabalho as $tipoTrabalho)
				<option value="{{ $tipoTrabalho->id }}">{{ $tipoTrabalho->nome }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('tipo_trabalho_id')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="titulo">Título</label>  
		  
		  <div class="col-sm-8 col-md-6">
			<input type="text" id="titulo" name="titulo" class="form-control input-md" placeholder="Título do Trabalho">
		  </div>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('titulo')}}</li>
				</div>
			@endif	
		</div>

		<div class="form-group">
			<label class="col-sm-4 col-md-3 control-label" for="area_id">Área</label>  
			<div class="col-sm-8 col-md-6">
		  	<select id="area_id" name="area_id" data-placeholder="Escolha a área" class="chosen-select form-control input-md">
				<option value=""></option>
				@foreach ($areas as $area)
				<option value="{{ $area->id }}">{{ $area->sigla }} - {{ $area->area }}</option>
				@endforeach
			</select>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('area_id')}}</li>
				</div>
			@endif	
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="cod">Código</label>  
		  
		  <div class="col-sm-3 col-md-2">
			<input type="text" id="cod" name="cod" class="form-control input-md" placeholder="Título do Trabalho">
		  </div>
		  	@if(count($errors)>0)
		  	 	<div class="text-danger">			
					<li style="list-style-type:none">{{$errors->first('cod')}}</li>
				</div>
			@endif	
		</div>
		
	    <div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="orientador_id">Orientadores</label>  

		  <div class="col-sm-8 col-md-6">
		  	<select id="orientador" name="orientador_id" data-placeholder="Escolha o Orientador" class="chosen-select form-control input-md">
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
		
	    <div class="form-group">
		  <label class="col-sm-4 col-md-3 control-label" for="coorientadores">Coorientadores</label>  
		  <div class="col-sm-8 col-md-6">
		  	<select id="coorientadores" name="coorientadores[]" multiple data-placeholder="Escolha os Coorientadores" class="chosen-select form-control input-md">
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
		  <label class="col-sm-4 col-md-3 control-label" for="estudantes">Estudantes</label>  
		  <div class="col-sm-8 col-md-6">
		  	<select id="estudantes" name="estudantes[]" multiple data-placeholder="Escolha os Estudantes" class="chosen-select form-control input-md">
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
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-8 col-md-6">
			<label class="control-label" for="maquete">
				<input type="checkbox" id="maquete" name="maquete" value="1">
				Este trabalho possui maquete
			</label>			
		  </div>
		</div>

		<div class="form-group">
		  <div class="col-sm-offset-4 col-md-offset-3 col-sm-10">
		    <button class="btn btn-primary" type="submit">Registrar</button>
		    <a href="/evento/trabalhos/{{ $evento->id }}" class="btn btn-danger">Cancelar</a>
		  </div>
		</div>		

		</fieldset>
	</form>
	</div>
</div>

@stop