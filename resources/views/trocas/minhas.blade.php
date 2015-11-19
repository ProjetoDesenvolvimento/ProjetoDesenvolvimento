@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <h4>Listado das solicitudes <small> </small></h4>

    <div>
      <?php foreach($solicitudesresp as $solicitud){ ?>

            <div>Usuario {{$solicitud["userdata"]->nome}}</div>
            <div>Livro {{$solicitud["object"]->solicitacao_A}}</div>
            <div>Data {{$solicitud["object"]->created_at}}</div>
            <a href="{{action('TrocaController@aceitarTroca',['troca_id' => $solicitud['object']->id])}}">Aceitar</a>
            <a href="{{action('TrocaController@rejeitarTroca',['troca_id' => $solicitud['object']->id])}}">Rejeitar</a>

       <?php }  ?>
    </div>

</div>

@stop
