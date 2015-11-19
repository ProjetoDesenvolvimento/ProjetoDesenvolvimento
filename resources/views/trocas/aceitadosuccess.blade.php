@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <h4>Já a solicitude foi encerrada, successo</h4>

    <div>
            Agora este livro  nao fez parte da sua lista, mas ainda vcs tem que decidir o jeito do intercambio, deve entrar em contato com ele

            <a href="{{action('TrocaController@getMinhasTrocas')}}">Voltar a minhas Trocas</a>



    </div>

</div>

@stop
