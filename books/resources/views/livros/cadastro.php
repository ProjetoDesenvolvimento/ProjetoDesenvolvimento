<html>
	<head>
		<title>Cadastro de livros</title>
		<script src="<?php echo asset('js/jquery.js')?>"></script>
		<script src="<?php echo asset('js/script_paginas/script_cadastro_livros.js')?>"></script>
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
		</style>
	</head>
	<body>
		<form id="form1" method="post" action="<?php echo action('LivrosController@cadastrarlivro');?>" accept-charset="UTF-8">

			<div id="mutant">
				<input type="hidden" id="id" name="id">
				ISBN
				<input type="text" id="isbn" name="isbn">
				<br />
				Título
				<?php
                     echo Form::text('titulo', '', array('id' => 'titulo',
                    'required'=>'required', 'type'=>'text'));
				?>

				<br />
				Descripción
				<input type="text" id="descripcion" required="required" name="descripcion">
				<br />
				Ano publicacao
				<input type="text" id="anio" name="anopubli">
				<br />
				Editora
				<input type="text" id="editora" name="editora">
				<br />
				Paginas
				<input type="text" id="paginas"  name="paginas">
				<br />
				Link Previo
				<input type="text" id="linkprevio" name="linkprevio">
				<br />
				Imagen
				<input type="text" id="linkprevioimg" name="imagenlink">
				<br />
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
		</form>
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
	</body>
</html>
