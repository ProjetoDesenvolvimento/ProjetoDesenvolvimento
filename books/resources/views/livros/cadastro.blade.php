@extends('layouts.master')

@section('content')



<iframe style="display: none" name="framePost"></iframe>

    {!! Form::open(array('url' => 'livros/cadastroliv','target'=>'framePost', 'method'=> 'post')) !!}
    <div class="col-md-8" id="mutant">
        <input type="hidden" id="id" name="id">
        <div class="form-group">
            <label for="isbn" class="control-label">ISBN:</label>
            {!! Form::text('isbn', '', array('id' => 'isbn', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}

            <div id="isbn-select" class=" form-control">

            </div>
        </div>

        <div class="form-group">
            <label for="nome" class="control-label">Titulo:</label>
             {!! Form::text('titulo', '', array('id' => 'titulo', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="descricao" class="control-label">Descrição:</label>
            {!! Form::text('descricao', '', array('id' => 'descricao', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="anopublicacao" class="control-label">Ano de publicação:</label>
            {!! Form::text('anopublicacao', '', array('id' => 'anopublicacao', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="editora" class="control-label">Editora:</label>
            {!! Form::text('editora', '', array('id' => 'editora', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="paginas" class="control-label">Páginas:</label>
            {!! Form::text('paginas', '', array('id' => 'paginas', 'class' => 'form-control', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="link" class="control-label">Link:</label>
            {!! Form::text('link', '', array('id' => 'link', 'class' => 'form-control', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="imagemurl" class="control-label">Imagem:</label>
            {!! Form::text('imagemurl', '', array('id' => 'imagemurl', 'class' => 'form-control', 'type'=>'text')); !!}
        </div>

        <fieldset>
            <legend>
                Autores
            </legend>
            <div id="autorescontainer">

            </div>
        </fieldset>
        <select name="estadolivro">
            <option value="1">Bom</option>
            <option value="2">Mais ou menos</option>
            <option value="3">Ruim</option>

        </select>
        <input type="button" id="agregarau" name="" value="Agregar Autor">
    </div>
    <input type="submit" value="Cadastrar">
    <input name="_token" type="hidden" value="<?php echo csrf_token() ?>"/>
    <div id="results"></div>
{!! Form::close() !!}
    <script>
        $(document).ready(function(){

            function repoFormatResult(book) {
                var markup = '<div class="row-fluid">' +
                    '<div style="width: 100%;">' +
                    '<div style="float:left;"><img src="' + book.volumeInfo.imageLinks.smallThumbnail + '" /></div>' +
                    '<div><span class="span6">' + book.volumeInfo.title + '</span></div>' +
                    '<div><span class="span6">' + book.volumeInfo.description + '</span></div>' +
                    '</div>' +
                    '<div style="clear:both;"></div>';

                if (book.description) {
                    markup += '<div>' + book.description + '</div>';
                }

                markup += '</div></div>';

                return markup;
            }

            function repoFormatSelection(book) {
                return book.volumeInfo.title;
            }

            $("#isbn-select").select2({
                placeholder: "Informe algo do livro",
                minimumInputLength: 2,
                ajax: {
                    url: 'https://www.googleapis.com/books/v1/volumes',
                    dataType: 'json',
                    delay: 250,

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
                initSelection: function(element, callback) {
                    // the input tag has a value attribute preloaded that points to a preselected repository's id
                    // this function resolves that id attribute to an object that select2 can render
                    // using its formatResult renderer - that way the repository name is shown preselected
                    var id = $(element).val();
                    if (id !== "") {
                        $.ajax("https://www.googleapis.com/books/v1/volumes/" + id, {
                            dataType: "json"
                        }).done(function(data) { callback(data); });
                    }
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                formatResult: repoFormatResult, // omitted for brevity, see the source of this page
                formatSelection: repoFormatSelection, // omitted for brevity, see the source of this page
                dropdownCssClass: "bigdrop"
            });


        });
    </script>
@stop