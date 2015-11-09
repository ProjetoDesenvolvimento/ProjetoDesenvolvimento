@extends('layouts.master')

@section('content')

		<style>
			#posibilidadescontainer {
				max-width: 300px;
				min-width: 300px;
				display: none;
				position: absolute;
			}
			.posibilidad_item:hover{
				cursor: hand;
			}
            .row-fluid:hover{
                background-color: #2779AA;
                color: #FFF;
            }

            .posibilidad_item{
                border: 2px solid gray;
                margin:5px;
                padding:5px;
                border-radius:2px 0 2px 0;
                background-color:rgba(255,255,255,0.6);
                color:black;
                font-size:1.2em;
                z-index:10000;

            }

            #posibilidades{
                max-height:350px;
                overflow-y:scroll;
                box-shadow: 0 0 5px black;
                z-index:10000;
            }
            .book_title, .book_isbn,.book_publication, .book_paginas{
                font-weight:900;
                margin:5px;
                font-size:1.2em;
            }

		</style>
<div class="container">
    <script src="{{ asset('js/script_paginas/script_cadastro_livros.js') }}"></script>
    <iframe style="display: none" name="framePost"></iframe>
        {!! Form::open(array('action' => 'LivroController@store', 'method'=> 'post')) !!}
        <div class="col-md-6" id="mutant">
            <input type="hidden" id="id" value="una" name="idgb">
            <div class="form-group">
                <label for="isbn-select" class="control-label">
                    Nome ou ISBN <span class="glyphicon glyphicon-info-sign" title="Informe o nome ou o ISBN do livro"></span>:
                </label>
                {!! Form::hidden('idgb', '', array('id' => 'idgb', 'class' => 'form-control', 'name'=>'idgb', 'required'=>'required')); !!}
                {!! Form::hidden('isbn', '', array('id' => 'isbn', 'class' => 'form-control', 'name'=>'isbn', 'required'=>'required')); !!}
                <div id="isbn-select" class=" form-control">

                </div>
            </div>
        <div style="display: none;">
            <div class="form-group">
                <label for="nome" class="control-label">
                    Titulo <span class="glyphicon glyphicon-info-sign" title="O título do livro, pelo qual a maioria das pessoas conhecem ele"></span>:
                </label>
                 {!! Form::text('titulo', '', array('id' => 'titulo', 'class' => 'form-control', 'name'=>'titulo', 'required'=>'required', 'type'=>'text')); !!}
            </div>
            <div class="form-group">
                <label for="descricao" class="control-label">
                    Descrição <span class="glyphicon glyphicon-info-sign" title="Uma descricao geral do livro, o conteudo."></span>:
                </label>
                {!! Form::text('descricao', '', array('id' => 'descricao', 'class' => 'form-control', 'name'=>'descricao','required'=>'required', 'type'=>'text')); !!}
            </div>
            <div class="form-group">
                <label for="anopublicacao" class="control-label">
                    Ano de publicação <span class="glyphicon glyphicon-info-sign" title="O ano em que o livro foi publicado para o mundo"></span>:
                </label>
                {!! Form::text('anopublicacao', '', array('id' => 'anopublicacao','name'=>'ano', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}
            </div>
            <div class="form-group">
                <label for="editora" class="control-label">
                    Editora <span class="glyphicon glyphicon-info-sign" title="Este é um dado nnao obrigatorio, ajuda a saber se realmente conhece o livro que cadastra"></span>:
                </label>
                {!! Form::text('editora', '', array('id' => 'editora', 'name'=>'editora', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}
            </div>
            <div class="form-group">
                <label for="paginas" class="control-label">
                    Páginas <span class="glyphicon glyphicon-info-sign" title="A quantidade de paginas que tem o livro"></span>:
                </label>
                {!! Form::text('paginas', '', array('id' => 'paginas','name'=>'paginas', 'class' => 'form-control', 'type'=>'text')); !!}
            </div>
            <div class="form-group">
                <label for="link" class="control-label">Link:</label>
                {!! Form::text('link', '', array('id' => 'link','class' => 'form-control', 'type'=>'text')); !!}
            </div>
            <div class="form-group">
                <label for="imagemurl" class="control-label">
                    Imagem <span class="glyphicon glyphicon-info-sign" title="O link da imagem do livro qeu voce quer cadastrar."></span>:
                </label>
                {!! Form::text('imagemurl', '', array('id' => 'imagemurl', 'name'=>'imagemurl', 'class' => 'form-control', 'type'=>'text')); !!}
            </div>
            <div class="form-group">
                <fieldset>
                    <legend>
                        Autores
                    </legend>
                    <div id="autorescontainer">

                    </div>
                </fieldset>
            </div>
            <div class="form-group" >

                <div class="col-md-5">
                    <label for="estadolivro" class="control-label">
                        Estado do livro atual <span class="glyphicon glyphicon-info-sign" title="Precisamos de sua honestidade, diga o estado real do livro que tem."></span>:
                    </label>
                    <select name="estadolivro">
                        <option value="1">Bom</option>
                        <option value="2">Mais ou menos</option>
                        <option value="3">Ruim</option>
                    </select>
                </div>
                <div class="col-md-4">
                      <label for="agregarau" class="control-label">
                        Adicionar autor <span class="glyphicon glyphicon-info-sign" title="Se o autor nao esta na lista e voce o conhece é importante para nos issa informacao"></span>:
                    </label>
                    <input type="button" id="agregarau" class="btn btn-primary" name="" value="Adicionar Autor">
                </div>
                <div class="col-md-3">
                    <input class="form-control btn-warning" type="submit" value="Cadastrar">
                </div>
            </div>
        </div>
            <input name="_token" type="hidden" value="<?php echo csrf_token() ?>"/>
            </div>
    {!! Form::close() !!}
            <!-- esta parte esta feita para apresentar os resultados ao usuario... nao se mostra por enquanto nao há resultados.-->
            <div id="posibilidadescontainer">
                <fieldset>
                    <legend>
                        Coincidencias...
                    </legend>

                    <div id="posibilidades">
                        <div id="containerajaxresp" >
                        </div>
                    </div>
                </fieldset>

            </div>
        <script>
            $(document).ready(function(){

                function repoFormatResult(book) {
                    var author = "Nao encontrado";
                    if (book.authors.length > 0)
                        author = book.authors[0].nome;
                    var markup = '<div class="row-fluid">' +
                        '<div style="width: 100%;">' +
                        '<div style="float:left;margin-right: 10px;"><img style="width: 80px;" src="' + book.smallThumbnail + '" /></div>' +
                        '<div><span style="font-weight: bold;" class="span6">' + book.title + '</span></div>' +

                        '<div><span class="span6">' + author + '</span></div>';
                        '<div><span class="span6">' + book.isbn + '</span></div>';


                    if (book.description) {
                        markup += '<div style="font-size: 10px;">' + book.description + '</div>';
                    }
                    markup += '</div>' +
                        '<div style="clear:both;"></div>';

                    return markup;
                }

                function repoFormatSelection(book) {
                    return book.title;
                }

                $("#isbn-select").select2({
                    placeholder: "Clique aqui e informe o nome ou o ISBN livro",
                    minimumInputLength: 2,
                    containerCssClass: "dropdown",
                    ajax: {
                        url: '/request/ajax/asinc/livros/getlivros/isbn/',
                        dataType: 'json',
                        delay: 1000,

                        data: function (term, page) {
                            return {
                                q: term, // search term
                            };
                        },
                        results: function (data, page) { // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to alter the remote JSON data

                            return { results: data.items };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                    formatResult: repoFormatResult, // omitted for brevity, see the source of this page
                    formatSelection: repoFormatSelection, // omitted for brevity, see the source of this page
                    dropdownCssClass: "bigdrop"
                });
                $('#isbn-select').on("select2-selecting", function(e) {
                    // what you would like to happen
                    //$("[name=idgb]").val(e.choice.idgb);
                   $("[name=isbn]").val(e.choice.id);
                   // $("[name=titulo]").val(e.choice.text);
                   // $("[name=descricao]").val(e.choice.description);
                   // $("[name=ano]").val(e.choice.year);
                   // $("[name=paginas]").val(e.choice.countPages);
                   /// $("[name=link]").val(e.choice.link);
                   // $("[name=imagemurl]").val(e.choice.smallThumbnail);
                   // $("[name=editora]").val(e.choice.publisher);
                    window.location = "/livro/tenho/"+e.choice.idgb;
                });

                $("[name=estadolivro]").select2();
            });
        </script>
</div>
@stop
