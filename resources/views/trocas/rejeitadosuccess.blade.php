@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <h4>Já a solicitude nao esta na lista</h4>

    <div>


            <a href="{{action('TrocaController@getMinhasTrocas')}}">Ver Minhas Trocas</a>



    </div>

</div>

@stop
