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

    protected function traer_pm($categoria)
    {
        if($categoria=='todo'){

            $data = DB::select("SELECT 
            e.nombre, avatarback, foto, texto, p.id publicacion_id, u.id user_id, p.created_at 
            from publicacion_emprendimiento p
            inner join emprendimiento e on e.id = p.emprendimiento_id
            inner join users u on u.id = e.user_id order by p.created_at desc");

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
        // $data = DB::select("SELECT 
        //     e.nombre, avatarback, texto, p.id publicacion_id, u.id user_id, p.created_at 
        // from publicacion_emprendimiento p
        // inner join emprendimiento e on e.id = p.emprendimiento_id
        // inner join users u on u.id = e.user_id where categoria_pymes_id = %% order by p.created_at desc");
    }
}
