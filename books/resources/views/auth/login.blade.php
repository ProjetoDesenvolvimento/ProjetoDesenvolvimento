@extends('layouts.master')

@section('content')
<!-- resources/views/auth/login.blade.php -->
<div class="container">
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
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Senha" name="senha" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Lembrar de mim
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-sm btn-success">Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop