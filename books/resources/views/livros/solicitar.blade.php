
@extends('layouts.master')

@section('content')
<div class="row">

    <div class="col-sm-6 col-md-4">

        <img class="img-responsive" style="width: 100%;" src="{{$result->imagemurl}}" alt="">
    </div>

    <div class="col-sm-5 col-md-7">
        <h3 >{{$result->titulo}}

        </h3>
        <a class="btn btn-default" href="{{asset('livro/solicitar-troca-usuario')}}/{{$result->livrousuario_id}}">Solicitar de {{$result->usuario_nome}}!</a>
        <h3>Descrição</h3>

        <p class="text-justify">{{$result->descricao}}</p>

        <p>{{$result->authors}}</p>


    </div>

</div>
@stop