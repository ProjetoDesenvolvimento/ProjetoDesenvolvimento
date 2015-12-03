@extends('layouts.master')

@section('content')
<p>Estes são os livros cadastrados</p>
<div id="products" class="row list-group">
    <?php $count = 0; ?>
    @foreach ($livros as $livro)
    <div class="tl-item item col-lg-2 col-md-4 col-sm-6 col-xs-12" data-toggle="modal" data-target="#modal{{$count}}">
        <div class="thumbnail">
            <h4 class=" text-center group inner list-group-item-heading">
                {{$livro->titulo}}</h4>
            <img class="group list-group-image" src="{{$livro->imagemurl}}" alt="" />
            <div class="caption">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <a style="width: 100%" class="btn btn-success" href="{{asset('livro/solicitar-troca')}}/{{$livro->livrousuario_id}}">Solicitar troca</a>
                    </div>
                </div>
            </div>
            <p class=" text-center">
                de {{$livro->usuario_nome}}</p>
        </div>
    </div>
    <?php $count++; ?>
    @endforeach
</div>

<?php $i = 0;?>
@foreach ($livros as $livro)
<!-- Modal -->
<div class="modal fade" id="modal{{$i}}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{$livro->titulo}}</h4>
            </div>
            <div class="modal-body">
                <p>{{$livro->descricao}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<?php $i++ ?>
@endforeach
 @stop