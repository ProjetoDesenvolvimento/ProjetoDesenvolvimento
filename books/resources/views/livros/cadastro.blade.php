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
		</style>

<iframe style="display: none" name="framePost"></iframe>
    {!! Form::open(array('action' => 'LivroController@store', 'method'=> 'post')) !!}
    <div class="col-md-8" id="mutant">
        <input type="hidden" id="id" value="una" name="idgb">
        <div class="form-group">
            <label for="isbn" class="control-label">ISBN:</label>
            <div id="isbn-select" class=" form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="nome" class="control-label">Titulo:</label>
             {!! Form::text('titulo', '', array('id' => 'titulo', 'class' => 'form-control', 'name'=>'titulo', 'required'=>'required', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="descricao" class="control-label">Descrição:</label>
            {!! Form::text('descricao', '', array('id' => 'descricao', 'class' => 'form-control', 'name'=>'descricao','required'=>'required', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="anopublicacao" class="control-label">Ano de publicação:</label>
            {!! Form::text('anopublicacao', '', array('id' => 'anopublicacao','name'=>'ano', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="editora" class="control-label">Editora:</label>
            {!! Form::text('editora', '', array('id' => 'editora', 'name'=>'editora', 'class' => 'form-control', 'required'=>'required', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="paginas" class="control-label">Páginas:</label>
            {!! Form::text('paginas', '', array('id' => 'paginas','name'=>'paginas', 'class' => 'form-control', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="link" class="control-label">Link:</label>
            {!! Form::text('link', '', array('id' => 'link','class' => 'form-control', 'type'=>'text')); !!}
        </div>
        <div class="form-group">
            <label for="imagemurl" class="control-label">Imagem:</label>
            {!! Form::text('imagemurl', '', array('id' => 'imagemurl', 'name'=>'imagemurl', 'class' => 'form-control', 'type'=>'text')); !!}
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
		<div id="posibilidadescontainer">
			<fieldset>
				<legend>
					Libros con un parecido son las posibilidades listo
				</legend>

				<div id="posibilidades">
					<div id="containerajaxresp" >
						<div id="posibilidad">
							<img src="7" />
							<span class="book_title">Titulo libro aqui va </span>
							<span class="book_isbn">ISBN aquí</span>
							<span class="book_description">Una descripcion rapida de esta cuestiòn aqui</span>
							<span class="book_publication">2015</span>
							<span class="book_moreinfo"><a href="">Aquí</a></span>
							<hr>
						</div>

					</div>
				</div>
			</fieldset>

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
                    '<div style="float:left;margin-right: 10px;"><img style="width: 80px;" src="' + book.smallThumbnail + '" /></div>' +
                    '<div><span style="font-weight: bold;" class="span6">' + book.title + '</span></div>' +
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
                placeholder: "Informe o isbn do Livro",
                minimumInputLength: 2,
                containerCssClass: "dropdown",
                ajax: {
                    url: '/request/ajax/asinc/livros/getlivros/isbn/',
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
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                formatResult: repoFormatResult, // omitted for brevity, see the source of this page
                formatSelection: repoFormatSelection, // omitted for brevity, see the source of this page
                dropdownCssClass: "bigdrop"
            });
            $('#isbn-select').on("select2-selecting", function(e) {
                // what you would like to happen
                console.log(e.choice)
                $("[name=titulo]").val(e.choice.text);
                $("[name=descricao]").val(e.choice.description);
                $("[name=ano]").val(e.choice.year);
                $("[name=paginas]").val(e.choice.countPages);
                $("[name=link]").val(e.choice.link);
                $("[name=imagemurl]").val(e.choice.smallThumbnail);
            });
        });
    </script>
@stop
