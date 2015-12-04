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
  <form action="{{asset('usuario/criar')}}" method="post" >
    <div class="create-content text-center">
      <h2>Cadastre-se para poder trocar seus livros!</h2>
    </div>
    <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4" id="mutant">
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
      <div class="form-group btns-create">
        {!! Form::submit('Cadastre-se', array('class' => 'btn col-lg-12 btn-success-tl')) !!}
        <div class="col-lg-12 btn btn-facebook">
          <a href="{{$loginUrl}}">Cadastre-se com Facebook</a>
        </div>
      </div>
    </div>
    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
  </form>
</div>
@stop
