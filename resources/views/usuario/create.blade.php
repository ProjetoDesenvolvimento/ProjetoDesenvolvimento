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
<div class="container-fluid">
<iframe style="display: none" name="framePost"></iframe>

    <form action="{{asset('usuario/criar')}}" method="post" target="framePost">

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
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    </form>

        </div>
    </div>
</div>
@stop