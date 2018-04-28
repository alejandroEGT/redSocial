<?php

namespace App\Http\Controllers;

use App\Solicitud;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AmigosController extends Controller
{
    public function show(){
    		$id = Auth::user()->id;

    		$user = DB::select("SELECT `u`.`id`, `u`.`nombres`, `u`.`apellidos`,`u`.`avatar`,`u`.`active` FROM `users` as `u` inner join `solicitud`as `s`on `s`.`user_solicita` = `u`.`id` or `s`.`user_acepta` = `u`.`id` where `u`.id != $id and ( `s`.`user_solicita` = $id or `s`.`user_acepta` = $id) and `s`.`id_estado` = 1");

    		return $user;
    }

    public function getAmigo($id)
    {
    	$amigo = User::find($id);
    	return $amigo;
    }
}
