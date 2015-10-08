@extends('layouts.master')

@section('content')
<script>
    function resultStore(r) {
        if (r !== "1"){
            alert("Falha ao cadastrar usuário!")
        }else{
            alert("Usuário cadastrado com sucesso!")
        }

    }
</script>

<iframe style="display: none" name="framePost"></iframe>
{!! Form::open(array('route' => array('usuario.store'),'target'=>'framePost', 'method'=> 'post')) !!}
    <div class="col-md-6" id="mutant">
        <div class="form-group">
            <label for="nome" class="control-label">Nome:</label>
            {!! Form::text('nome', '',array('required'=>'required', 'class' => 'form-control', 'placeholder' => 'Nome')) !!}
        </div>
        <div class="form-group">
            <label for="email" class="control-label">Email:</label>
            {!! Form::text('email', '',array('required'=>'required', 'class' => 'form-control', 'placeholder' => 'Email')) !!}
        </div>
        <div class="form-group">
            <label for="senha" class="control-label">Senha:</label>
            {!! Form::password('senha', array('required'=>'required', 'class' => 'form-control', 'placeholder' => 'Senha')) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Salvar', array('class' => 'btn btn-primary')) !!}
        </div>
    </div>
{!! Form::close() !!}
        </div>
    </div>
@stop