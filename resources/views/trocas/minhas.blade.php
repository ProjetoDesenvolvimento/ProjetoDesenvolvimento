@extends('layouts.master')

@section('content')

<div class="container">
    <fieldset>
        <legend>As minhas solicitudes</legend>
        <p>Nesta pagina voce pode ver as solicitudes que voce tem pedentes de outros usuarios no sistema, por favor confira o rejeite as solicitudes</p>

    <div>
      <?php foreach($solicitudesresp as $solicitud){ ?>
        <div class="row">
            <div class="col-xs-3">
                 <div class="thumbnail">
                      <img class="group list-group-image img-responsive img-circle" src="{{$solicitud['livrodetail']->imagemurl}}" alt="" />
                 </div>
            </div>
            <div class="col-xs-5">
                <p><strong>Solicitante:</strong> {{$solicitud["userdata"]->nome}}</p>
                <p><strong>O Livro:</strong> {{$solicitud["livrodetail"]->titulo}}</p>
                <p><strong>Data: </strong> {{$solicitud["object"]->created_at}}</p>
                <p>
                     <a class="btn btn-success" href="{{action('TrocaController@aceitarTroca',['troca_id' => $solicitud['object']->id])}}">Aceitar</a>
                     <a class="btn btn-danger"href="{{action('TrocaController@rejeitarTroca',['troca_id' => $solicitud['object']->id])}}">Rejeitar</a>
                </p>
            </div>
            <div class="col-xs-4">

            </div>

        </div>
       <?php }  ?>
    </div>
    </fieldset>
</div>

@stop
