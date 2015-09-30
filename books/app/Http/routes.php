<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'MainController@index');

Route::resource('livro', 'LivroController');
Route::resource('usuario', 'UsuarioController');

Route::get('/livros/cadastro','LivrosController@cadastro');
Route::post('/livros/cadastroliv','LivrosController@cadastrarlivro');
Route::get('/livros/tenho/{id}','LivrosController@tenho');
Route::post('/livros/tenho/{id}','LivrosController@cadastrarLivroUsuario');

Route::get('/request/ajax/asinc/livros/getlivros/type/{type}/criteria/{criteria}', ['as' => 'verdato', 'uses' => 'LivrosController@verdato']);
Route::get('/livros/feed','LivrosController@obterfeed');

