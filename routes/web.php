<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{vue?}', function () {
    return view('welcome');
});


Route::resource('/user','UserController');
Route::resource('geoip','GeoIpController');

Route::get('users/autocomplete','UsersSystemController@filter');

Route::get('users/categorias','UsersSystemController@categorias');

// Route::get('categorias', function(){

//     dd("hola");

//     return [
        //   ['value' =>'', 'text' => 'Seleccione..' ], 
        //   ['value' =>'1', 'text' => 'Gastronómico'  ], 
        //   ['value' =>'2', 'text' => 'Turístico'  ],  
        //   ['value' =>'3', 'text' => 'Cuidado personal'  ],  
        //   ['value' =>'4', 'text' => 'Entretenimiento y Ocio'  ], 
        //   ['value' =>'5', 'text' => 'tecnológico' ],   
        //   ['value' =>'6', 'text' => 'Deporte' ],           
        //   ['value' =>'7', 'text' => 'Artesanía'],  
        //   ['value' =>'8', 'text' => 'Belleza' ],          
//     ];
// });