<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComentarioMultiple extends Model
{
    protected $table = "comentario_multiple";

    protected function comentar_a($datos)
    {
    	$this->id_user = Auth::user()->id;
    	$this->texto = $datos->texto;
    	if($this->save()){
    		$comentar_a = DB::table('comentario-user')->insert([
    			'id_comentario' => $this->id,
    			'id_user_recibe' => $datos->id_user_recibe,
    		]);

    		if ($comentar_a) {
    			return true;
    		}
    		return false;
    	}
    }
    protected function traerComentariosDelMuro($id)
    {
    	$comentTo = DB::table('comentario_multiple')
    			   ->select([
    			   		'comentario_multiple.id as id',
  						'comentario-user.id as id_padre',
  						'ur.id as id_user_recibe',
    			   		'ur.nombres as usuario_recibe',
    			   		'ur.avatar as avatarRecibe',
    			   		'ue.id as id_user_envia',
    			   		'ue.nombres as usuario_envia',
    			   		'ue.avatar as avatarEnvia',
    			   		'comentario_multiple.texto as texto',
    			   		'comentario_multiple.created_at as created_at'
    			   ])
    			   ->join('comentario-user','Comentario-user.id_comentario','comentario_multiple.id')
    			   ->join('users as ur','ur.id','Comentario-user.id_user_recibe')
    			   ->join('users as ue','ue.id','comentario_multiple.id_user')
				   ->where('comentario-user.id_user_recibe', $id)
				   ->orderBy('created_at','asc')
    			   ->get();
        return $comentTo;

    }
    protected function yoAalguien($id){
    	$query = DB::table('comentario_multiple')
    			->select([
    				'comentario_multiple.id as id',
    				'ur.id as id_user_recibe',
    				'ur.nombres as usuario_recibe',
    				'ue.id as id_user_envia',
    				'ue.nombres as usuario_envia',
    				'comentario_multiple.texto as texto',
    				'ur.avatar as avatarRecibe',
    				'ue.avatar as avatarEnvia'
    			])
    			->join('comentario-user as cu','cu.id_comentario','comentario_multiple.id')
    			->join('users as ur','ur.id','cu.id_user_recibe')
    			->join('users as ue', 'ue.id','comentario_multiple.id_user')
    			->where('comentario_multiple.id_user', $id)->get();
    	return $query;
    }
}
