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

//Route::get('/livros/cadastro','LivrosController@cadastro');
//Route::post('/livros/cadastroliv','LivrosController@cadastrarlivro');
Route::post('/livros/cadastroliv','LivroController@store');

Route::get('/livros/tenho/{idgb}/{id}','LivroController@tenho');

Route::get('/livros/create','LivroController@create');
Route::get('/livros','LivroController@obterfeed');
Route::post('/livros/tenho/id/{id}/idgb/{idgb}','LivroController@cadastrarLivroUsuario');

Route::get('/request/ajax/asinc/livros/getlivros/type/{type}/criteria/{criteria}', ['as' => 'verdato', 'uses' => 'LivroController@verdato']);
Route::get('/livros/feed','LivroController@obterfeed');
Route::get('/livros/feed/pag/{index}', ['as' => 'obterfeed', 'uses' => 'LivroController@obterfeed']);
