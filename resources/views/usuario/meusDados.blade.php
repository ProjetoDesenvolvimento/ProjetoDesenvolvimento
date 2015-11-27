@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <fieldset>
        <legend>Meus livros</legend>
        @if (count($livros) > 0)
        <p>Estes são os seus livros cadastrados</p>
        <div id="products" class="row list-group">
        @foreach ($livros as $livro)
            <div class="tl-item item col-md-3 col-sm-4 col-xs-6">
                <div class="thumbnail">
                    <h4 class=" text-center group inner list-group-item-heading">
                        {{$livro->titulo}}</h4>
                    <img class="group list-group-image" src="{{$livro->imagemurl}}" alt="" />
                    <div class="caption">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <span>Cadastrado {{$livro->created_at}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        @else
        <p>Você não possui livros cadastrados</p>
        @endif
    </fieldset>

    <fieldset>
        <legend>Minhas solicitações de troca</legend>
        @if (count($livros) > 0)
        <p>Estas são as suas solicitações pedentes que fizeram para você, aceite ou rejeite:</p>
        @foreach($solicitacoes as $troca)
            <div class="row">
                <div class="col-xs-3">
                    <div class="thumbnail">
                        <img class="group list-group-image img-responsive img-circle" src="{{$troca['livrodetail']->imagemurl}}" alt="" />
                    </div>
                </div>
                <div class="col-xs-5">
                    <p><strong>Solicitante:</strong> {{$troca["userdata"]->nome}}</p>
                    <p><strong>O Livro:</strong> {{$troca["livrodetail"]->titulo}}</p>
                    <p><strong>Data: </strong> {{$troca["object"]->created_at}}</p>
                    <p>
                        <a class="btn btn-success" href="{{action('TrocaController@aceitarTroca',['troca_id' => $troca['object']->id])}}">Aceitar</a>
                        <a class="btn btn-danger"href="{{action('TrocaController@rejeitarTroca',['troca_id' => $troca['object']->id])}}">Rejeitar</a>
                    </p>
                </div>
                <div class="col-xs-4">

                </div>

            </div>
        @endforeach
        @else
        <p>Você não possui solicitações de troca</p>
        @endif

    </fieldset>

    <fieldset>
        <legend>Minhas trocas</legend>
        @if (count($livros) > 0)
        <p>Estas são as suas trocas:</p>
        @foreach($trocas as $troca)
        <div class="tl-item item col-md-4 col-sm-4 col-xs-12">
            <div class="thumbnail">
                <h4 class=" text-center group inner list-group-item-heading">
                    {{$livro->titulo}}</h4>
                <img class="group list-group-image" src="{{$troca['livrodetail']->imagemurl}}" alt="" />
                <div class="caption">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <p><strong>Solicitante:</strong> {{$troca["userdata"]->nome}}</p>
                            <p><strong>O Livro:</strong> {{$troca["livrodetail"]->titulo}}</p>
                            <p><strong>Data: </strong> {{$troca["object"]->created_at}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        @endforeach
        @else
        <p>Você não possui solicitações de troca</p>
        @endif

    </fieldset>
</div>
@stop
