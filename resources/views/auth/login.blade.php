@extends('layouts.master')

@section('content')
<div class="container-fluid">

  <div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
      <div class="login-panel panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Autenticar</h3>
        </div>
        <div class="panel-body">
          <form action="login" method="post" role="form">
            {!! csrf_field() !!}
            <fieldset>
              <div class="form-group">
                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="" />
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Senha" name="senha" type="password" value="" />
              </div>              
              <div class="form-group btns-create">
                <button type="submit" class="btn col-lg-12 btn-success-tl">Entrar</button>
                <div class="col-lg-12 btn btn-facebook">
                  <a href="{{$loginUrl}}">Entrar com Facebook</a>

                </div>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
