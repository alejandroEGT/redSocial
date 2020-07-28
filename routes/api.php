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
Route::post('auth/login_fb', 'AuthController@login_facebook');

Route::post('registro_pyme','UserController@store');
Route::post('registrar_por_facebook','UserController@registrar_por_facebook');
Route::post('validar_si_existe_email_en_sistema','UserController@validar_si_existe_email_en_sistema');

Route::get('emprendimientos_mes/{cantidd}', 'PublicController@emprendedores_mes');
Route::get('traer_publicaciones','postear_a_alguienController@traer_publicaciones');
Route::get('traer_pm_publicaciones/{categoria}','postear_a_alguienController@traer_pm_publicaciones');
Route::get('auth/datos_perfil/{id}','UserController@datos_perfil_by_user');
Route::get('galeria/{id}','postear_a_alguienController@galeria_by_user');


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
  Route::post('publicar_post_user','postear_a_alguienController@publicar_post_user');
  Route::post('publicar_post_empresa','postear_a_alguienController@publicar_post_empresa');
  
  // Route::get('traer_publicaciones','postear_a_alguienController@traer_publicaciones');
  Route::get('publicador','UserController@publicador');
  Route::get('galeria','postear_a_alguienController@galeria');
  


  Route::get('auth/chatIndex', 'ChatController@index');
  Route::get('auth/messages/{id}', 'ChatController@fetch');
  Route::post('auth/messages', 'ChatController@sentMessage');

  Route::post('auth/user/updatefoto','UserController@update_foto');
  Route::post('auth/user/updatefotoback','UserController@update_fotoback');

  Route::get('auth/get_amigos/{id_user}','UsersSystemController@get_amigos_by_id');
  Route::get('auth/get_user/{id_user}','UsersSystemController@get_usuario');
  Route::get('auth/get_amigos_en_comun','UserController@users_en_comun');

  Route::get('auth/notifi_mensajes/{id}','ChatController@show_notificacion_mensaje');

  //new

  Route::get('auth/contacto', 'UserController@contacto');
  Route::post('auth/editar_perfil', 'UserController@editar_perfil');
  Route::post('auth/crear_mi_emprendimiento','UserController@crear_mi_emprendimiento');
  Route::get('auth/datos_perfil','UserController@datos_perfil');
  
  

});
Route::group(['middleware' => ['jwt.refresh', 'throttle:rate_limit,1']], function(){
Route::get('auth/refresh', 'AuthController@refresh');
});