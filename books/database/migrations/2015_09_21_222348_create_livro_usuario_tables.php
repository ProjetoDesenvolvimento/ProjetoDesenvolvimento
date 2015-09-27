<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivroUsuarioTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autor', function (Blueprint $table) {
            $table->increments('codigo');
            $table->string('nome');
            $table->timestamps();
        });


        Schema::create('genero', function (Blueprint $table) {
            $table->increments('codigo');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('editora', function (Blueprint $table) {
            $table->increments('codigo');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('livro', function (Blueprint $table) {
            $table->increments('codigo');
            $table->string('isbn');
            $table->unique('isbn');
            $table->string('titulo');
            $table->index('titulo');
            $table->text('descricao');
            $table->integer('ano');
            $table->integer('paginas');
            $table->text('imagemurl');
            $table->timestamps();
        });

        Schema::create('livroautor', function (Blueprint $table) {
            $table->increments('codigo');
            $table->integer('autor_codigo');
            $table->integer('livro_codigo');
            $table->unique(array('autor_codigo','livro_codigo'));
            $table->timestamps();
        });

        Schema::create('livrogenero', function (Blueprint $table) {
            $table->increments('livrogenerocodigo');
            $table->integer('livro_codigo');
            $table->integer('genero_codigo');
            $table->unique(array('livro_codigo','genero_codigo'));
            $table->timestamps();
        });

        Schema::create('livrousuario', function (Blueprint $table) {
            $table->increments('codigo');
            $table->integer('livro_codigo');
            $table->integer('usuario_codigo');
            $table->integer('estado');
            $table->timestamps();
        });

        Schema::create('livroeditora', function (Blueprint $table) {
            $table->increments('codigo');
            $table->integer('livro_codigo');
            $table->integer('editora_codigo');
            $table->unique(array('livro_codigo','editora_codigo'));
            $table->timestamps();
        });

        Schema::create('recomendacao', function (Blueprint $table) {
            $table->increments('codigo');
            $table->integer('usuario_codigo');
            $table->integer('genero_codigo');
            $table->unique(array('usuario_codigo','genero_codigo'));
            $table->timestamps();
        });

        Schema::create('telefone', function (Blueprint $table) {
            $table->increments('codigo');
            $table->string('numero',13);
            $table->timestamps();
        });

        Schema::create('usuariotelefone', function (Blueprint $table) {
            $table->increments('codigo');
            $table->integer('usuario_codigo');
            $table->integer('telefone_codigo');
            $table->unique(array('usuario_codigo','telefone_codigo'));
            $table->timestamps();
        });

        Schema::create('troca', function (Blueprint $table) {
            $table->increments('codigo');
            $table->integer('livrousuario_codigo');
            $table->integer('usuario_codigo');
            $table->integer('estado');
            $table->unique(array('livrousuario_codigo','usuario_codigo'));
            $table->timestamps();
        });

        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('codigo');
            $table->string('nome',80);
            $table->string('email',80);
            $table->string('endereco',80);
            $table->string('senha',80);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autor');
        Schema::drop('genero');
        Schema::drop('livro');
        Schema::drop('livroautor');
        Schema::drop('livrogenero');
    }
}
