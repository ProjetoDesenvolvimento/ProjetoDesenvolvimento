@extends('layouts.master')

@section('content')
    <div class="row tl-container">
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 text-center t1-content">
            <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget vehicula risus. Nam sed condimentum nibh. Ut ac ante accumsan, sodales odio nec, pretium tellus.</h2>
        </div>

        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2 t1-search">
            <input class="form-control" type="text" placeholder="Digite o nome do livro que deseja encontrar..."/>
        </div>
        <div class="text-center col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <button class="btn btn-default t1-btn" type="submit">Buscar</button>
        </div>
    </div>

    <!-- Começa carousel -->
    <div id="carousel-t2" class="row carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-t2" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-t2" data-slide-to="1"></li>
        <li data-target="#carousel-t2" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <div class="carousel-caption">
            <h3>Teste 1</h3>
          </div>
        </div>
        <div class="item">
          <div class="carousel-caption">
            <h3>Teste 2</h3>
          </div>
        </div>
        <div class="item">
          <div class="carousel-caption">
            <h3>Teste 3</h3>
          </div>
        </div>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-t2" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-t2" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <!-- Termina -->

    <div class="row t3-content">
      <h3>Olá {!! $user["email"] !!}</h3>

      <div><a href="usuario/create">Criar usuario</a></div>
      <div><a href="livro/show">Mostra livros</a></div>
      <div><a href="livros/create">Cadastrar livro</a></div>
      <div><a href="livro/trocar">Trocar livro</a></div>

    </div> 

@stop