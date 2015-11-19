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
        if (Schema::hasTable('autor'))
        Schema::drop('autor');

        if (Schema::hasTable('genero'))
        Schema::drop('genero');

        if (Schema::hasTable('livro'))
        Schema::drop('livro');

        if  (Schema::hasTable('livroautor'))
        Schema::drop('livroautor');

        if (Schema::hasTable('livrogenero'))
        Schema::drop('livrogenero');

        if (Schema::hasTable('livroeditora'))
        Schema::drop('livroeditora');

        if (Schema::hasTable('livrousuario'))
        Schema::drop('livrousuario');

        if (Schema::hasTable('editora'))
        Schema::drop('editora');

        if (Schema::hasTable('usuario'))
        Schema::drop('usuario');

        if (Schema::hasTable('troca'))
        Schema::drop('troca');

        if (Schema::hasTable('usuariotelefone'))
        Schema::drop('usuariotelefone');

        if (Schema::hasTable('telefone'))
        Schema::drop('telefone');

        if (Schema::hasTable('recomendacao'))
        Schema::drop('recomendacao');

        if (Schema::hasTable('notification'))
        Schema::drop('notification');

        if (Schema::hasTable('solicitacaotroca'))
        Schema::drop('solicitacaotroca');

        if (Schema::hasTable('users'))
        Schema::drop('users');

        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id');
            $table->string('texto',1500);
            $table->integer('tipo');
            $table->string('emailorigen',80);
            $table->string('emailobjeti',80);
            $table->integer('estado');
            $table->timestamps();
        });

        Schema::create('autor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });


        Schema::create('genero', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('editora', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('livro', function (Blueprint $table) {
            $table->increments('id');
            $table->string('isbn');
            $table->unique('isbn');
            $table->string('idgb');
            $table->unique('idgb');
            $table->text('titulosearch');
            $table->index('titulosearch');
            $table->text('titulo');
            $table->index('titulo');
            $table->text('descricao');
            $table->string('ano');
            $table->integer('paginas');
            $table->text('imagemurl');
            $table->timestamps();
        });

        Schema::create('livroautor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('autor_id');
            $table->integer('livro_id');
            $table->unique(array('autor_id','livro_id'));
            $table->timestamps();
        });

        Schema::create('livrogenero', function (Blueprint $table) {
            $table->increments('livrogeneroid');
            $table->integer('livro_id');
            $table->integer('genero_id');
            $table->unique(array('livro_id','genero_id'));
            $table->timestamps();
        });

        Schema::create('livrousuario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('livro_id');
            $table->integer('usuario_id');
            $table->integer('estado');
            $table->timestamps();
        });

        Schema::create('livroeditora', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('livro_id');
            $table->integer('editora_id');
            $table->unique(array('livro_id','editora_id'));
            $table->timestamps();
        });

        Schema::create('recomendacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id');
            $table->integer('genero_id');
            $table->unique(array('usuario_id','genero_id'));
            $table->timestamps();
        });

        Schema::create('telefone', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero',13);
            $table->timestamps();
        });

        Schema::create('usuariotelefone', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id');
            $table->integer('telefone_id');
            $table->unique(array('usuario_id','telefone_id'));
            $table->timestamps();
        });

        Schema::create('solicitacaotroca', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('livrousuario_id');
            $table->integer('usuario_solicitante');
            $table->integer('usuario_proprietario');
           // $table->unique(array('livrousuario_id','usuario_id'));
            $table->timestamps();
        });

        Schema::create('troca', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('solicitacao_A')->default("-1"); // ORIGEM
            $table->integer('solicitacao_B')->default("-1"); // ACEITE
            $table->integer('estado');
            $table->integer('idsolicitante');
            $table->index('solicitacao_A');
            $table->index('solicitacao_B');
            $table->unique(array('solicitacao_A','solicitacao_B'));
            $table->timestamps();
        });

        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',80);
            $table->string('email',80);
            $table->string('senha',80);
            $table->string('remember_token', 255);
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
        Schema::drop('livroeditora');
        Schema::drop('livrousuario');
        Schema::drop('editora');
        Schema::drop('usuario');
        Schema::drop('troca');
        Schema::drop('usuariotelefone');
        Schema::drop('telefone');
        Schema::drop('recomendacao');
        Schema::drop('notification');
    }
}
