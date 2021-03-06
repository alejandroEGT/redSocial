<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', 'AuthController@login');
Route::post('auth/login_api', 'AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('auth/user', 'AuthController@user');
  Route::post('auth/logout', 'AuthController@logout');
  Route::resource('auth/getUserNews', 'UsersSystemController');
  Route::resource('auth/comment','PensamientoController');

  Route::post('auth/jsonfoto', 'PensamientoController@jsonFoto');
  Route::post('auth/fotoChat', 'ChatController@sendFoto');
  Route::resource('auth/commentTo','postear_a_alguienController');
  Route::get('auth/dirigido/{id}','postear_a_alguienController@dirigidos');
  Route::resource('auth/solicitud', 'SolicitudController');
  Route::post('auth/aceptarSolicitud', 'SolicitudController@aceptarSolicitud');
  Route::get('auth/amigos','AmigosController@show');
  Route::get('auth/amigo/{id}','AmigosController@getAmigo');
  


  Route::get('auth/chatIndex', 'ChatController@index');
  Route::get('auth/messages/{id}', 'ChatController@fetch');
  Route::post('auth/messages', 'ChatController@sentMessage');

  Route::post('auth/user/updatefoto','UserController@update_foto');
  Route::post('auth/user/updatefotoback','UserController@update_fotoback');

  Route::get('auth/get_amigos/{id_user}','UsersSystemController@get_amigos_by_id');
  Route::get('auth/get_user/{id_user}','UsersSystemController@get_usuario');
  Route::get('auth/get_amigos_en_comun','UserController@users_en_comun');

  Route::get('auth/notifi_mensajes/{id}','ChatController@show_notificacion_mensaje');


});
Route::group(['middleware' => ['jwt.refresh', 'throttle:rate_limit,1']], function(){
  Route::get('auth/refresh', 'AuthController@refresh');
});