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
    public function emprendedores_mes()
    {
        $d = DB::select("SELECT 
                            user_id,
                            nombre_pyme,
                            avatar,
                            contacto,
                            u.created_at,
                            text categoria
                        from users as u
                        left join user_contacto c on c.user_id = u.id
                        inner join categoria_pymes ca on ca.id = u.categoria_pyme_id
                        where 
                        extract(month from u.created_at) = (select extract(month from now())) and rol_id=1");
        
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
