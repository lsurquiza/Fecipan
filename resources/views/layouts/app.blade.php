<!doctype html>
<html>
    <head>
        <title>FrEvO IFMS - Framework de Eventos Organizacionais</title>
        <meta charset="utf-8">
        
        <!-- Vincular com o arquivo css do Bootstrap -->
		<!--
  <link rel="stylesheet" href="/chosen/docsupport/style.css">
  <link rel="stylesheet" href="/chosen/docsupport/prism.css">
		-->

		<link rel="stylesheet" href="/chosen/chosen.css">
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/theme.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.css">
        

		<!-- Vincular com os arquivos javascript do Bootstrap -->
		<!--<script src="/chosen/docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>-->
		<script src="/js/jquery-3.3.1.js" type="text/javascript"></script>
		<script src="/js/jquery.dataTables.js"></script>
        <script src="/js/bootstrap.js"></script>
        <script>
$(document).ready( function () {
    $('#table').DataTable();
} );
		</script>
      </head>
    
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>
              <a class="navbar-brand" href="/">
                <span class="glyphicon glyphicon-user"></span> FrEvO
              </a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav">
                @if (Auth::check())
                  @if (Auth::user()->perfil->administrador == true)
                    <li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Pessoas <span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li><a href="/usuario">Usuários</a></li>
						  <li class="divider"></li>
						  <li><a href="/pessoa/avaliadores">Avaliadores</a></li>
						  <li><a href="/pessoa/estudantes">Estudantes</a></li>
						  <li><a href="/pessoa/orientadores">Orientadores</a></li>
						</ul>
					</li>
                    <li><a href="/perfil">Perfis</a></li>
                    <li><a href="/conteudo">Conteúdos</a></li>
				  @else 
					@if (Auth::user()->perfil->descricao == "Organizador")
                    <li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Pessoas <span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li><a href="/pessoa/avaliadores">Avaliadores</a></li>
						  <li><a href="/pessoa/estudantes">Estudantes</a></li>
						  <li><a href="/pessoa/orientadores">Orientadores</a></li>
						</ul>
					</li>
                    <li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Cadastros <span class="caret"></span></a>
						<ul class="dropdown-menu">
						  <li><a href="/area">Áreas</a></li>
						  <li><a href="/categoria">Categorias</a></li>
						  <li><a href="/tipoTrabalho">Tipos de Trabalhos</a></li>
						</ul>
					</li>
					<li><a href="/evento">Eventos</a></li>
					@elseif (Auth::user()->perfil->descricao == "Auxiliar de Avaliação")
					<li><a href="/evento">Eventos</a></li>
					@endif
                  @endif
                @endif
              </ul>
              <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span> 
                            {{ Auth::user()->pessoa->nome }} -
							{{ Auth::user()->perfil->descricao }}
							<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-log-out"></span> Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
              </ul>
            </div>
          </div>
        </nav>
        <div class="container text-justify">
            @yield('conteudo')

            <hr class="featurette-divider">
            
            <!-- FOOTER -->
            <footer>
                <p class="pull-right"><a href="#">Topo da Página</a></p>
                <p><a href="http://www.ifms.edu.br/" target="_blank">IFMS</a> 2017-2</p>
                <p><a href="https://laravel.com/docs/5.3" target="_blank">Laravel 5.3</a></p>
            </footer>
        </div>
		<script src="/chosen/chosen.jquery.js" type="text/javascript"></script>
		<script src="/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
		<script src="/chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>