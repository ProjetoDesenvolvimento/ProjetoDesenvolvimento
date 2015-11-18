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

// Authentication routes...
Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');
Route::get('logout', 'AuthController@getLogout');
Route::get('loginfb', 'AuthController@postLoginFromFacebook');


// Registration routes...
Route::get('auth/register', 'AuthController@getRegister');
Route::post('auth/register', 'AuthController@postRegister');

Route::get('/', 'MainController@index');


Route::get('/livro/destacados/', 'LivroController@getDestacados');
Route::get('/livro/destacados/{id}', 'LivroController@getDestacados');

Route::get('/livro/feed/', 'LivroController@getFeed');
Route::get('/livro/feed/{id}', 'LivroController@getFeed');
Route::get('/livro/booksbyuser/{idusuario}', 'LivroController@getBooksByUser');


Route::get('/usuario/criarffb', 'UsuarioController@criarUsuarioFromFacebook');

Route::post('/usuario/resetpassword', 'UsuarioController@resetPassword');
Route::get('/usuario/criar', 'UsuarioController@getCriar');
Route::post('/usuario/criar', 'UsuarioController@postCriar');

Route::group(array('middleware'=>'auth'), function(){
    Route::controller('troca', 'TrocaController');
    Route::controller('livro', 'LivroController');
    Route::controller('usuario', 'UsuarioController');
});

Route::post('/livros/cadastroliv','LivroController@store');

Route::get('/request/ajax/asinc/livros/getlivros/{type}', ['as' => 'verdato', 'uses' => 'LivroController@verdato']);
Route::get('/request/ajax/asinc/livros/getlivros/type/{type}/criteria/{criteria}', ['as' => 'verdato', 'uses' => 'LivroController@verdato2']);//a peesquica no formulario

//notifications
Route::get('/user/notifications','NotificationsController@getUserNotifications');
Route::get('/user/last_notifications','NotificationsController@getUserLastNotifications');



