<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Publicaciones extends Model
{
    protected $table = "publicaciones_users";

    protected function traer()
    {
        $data = DB::select("SELECT nombre, avatar, texto, p.id publicacion_id, u.id user_id, p.created_at from publicaciones_users p
                            inner join users u on u.id = p.user_id order by p.created_at desc");

        
        if (count($data)>0) {

            for ($i=0; $i < count($data) ; $i++) { 
                $data[$i]->created_at = Carbon::parse($data[$i]->created_at)->diffForHumans();
            }
            return [
                'estado'=> 'success',
                'data' => $data
            ];
        }else{
            return [
                'estado'=> 'failed',
                'data' => null
            ];
        }
    }
}
