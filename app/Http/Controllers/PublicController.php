<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function __construct(){
        Carbon::setLocale('es');
    }
    public function emprendedores_mes($cantidad)
    {
        $d = DB::select("SELECT 
                    user_id,
                    e.nombre,
                    avatarback avatar,
                    contacto,
                    u.created_at,
                    text categoria
                from emprendimiento e
                inner join users u on u.id = e.user_id
                inner join categoria_pymes cp on cp.id = e.categoria_pymes_id
                where
                extract(month from e.created_at) = (select extract(month from now())) and rol_id=1
                limit $cantidad
                ");
                        
                        for ($i=0; $i < count($d) ; $i++) { 
                            $d[$i]->created_at = Carbon::parse($d[$i]->created_at)->diffForHumans();
                        }
                        
                        if (count($d)>0) {
                            return[
                                'estado'=>'success',
                                'response'=>$d
                            ];
                        }
                        return[
                                'estado'=>'failed',
                                'response'=>null
                            ];

    }
}
