@extends('layouts.master')

@section('content')
<div class="container-fluid">
<iframe style="display: none" name="framePost"></iframe>
    <form action="{{action('UsuarioController@resetPassword')}}" method="post">

        <div class="col-md-6" id="mutant">
            <div class="form-group">
                <label for="nome" class="control-label">Nome: {{$usuario->nome}}</label>
                <input type="hidden" value="{{$usuario->id}}" name="id">

            </div>
            <div class="form-group">
                <label for="email" class="control-label">Email: {{$usuario->email}}</label>
            </div>
            <div class="form-group">
                <label for="senha" class="control-label">Senha:</label>
                {!! Form::password('senha', array('required'=>'required', 'class' => 'form-control', 'placeholder' => 'Senha')) !!}
            </div>
            <div class="form-group">
                <label for="senha" class="control-label">Senha Novamente:</label>
                {!! Form::password('o', array('required'=>'required', 'class' => 'form-control', 'placeholder' => 'Confirmar Senha')) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary')) !!}
            </div>
        </div>
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    </form>

        </div>
    </div>
</div>
@stop
