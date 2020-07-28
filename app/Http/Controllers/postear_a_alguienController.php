<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Publicaciones;
use App\Emprendimiento;
use App\ComentarioSimple;
use App\ComentarioMultiple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\publicacion_emprendimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class postear_a_alguienController extends Controller
{
    public function __construct(){
        Carbon::setLocale('es');
    }
	public function index()
	{
		
	}
    public function create()
    {
        //s
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $coment = ComentarioMultiple::comentar_a($request);
        if ($coment) {
        	return "true";
        }
        return "false";
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



        //return "retornar ".$id;
       $a = ComentarioSimple::join('users as u','comentario_simple.id_user','u.id')
        ->where('id_user', $id)->get();
        $b = ComentarioMultiple::traerComentariosDelMuro($id);
        $c = ComentarioMultiple::yoAalguien($id);

        
    	//$a = '{"1":"A","2":"V","3":"C"}';
		//$b = '{"1":"X","2":"XL","3":"XM","4":"L"}';

		$a = json_decode($a,true);
		$b = json_decode($b,true);
		$c = json_decode($c,true);

		$order = array_merge($a, $b, $c);

		return ($order);
        //return json_encode(array_merge(array_filter($a),json_decode($b, true)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function jsonFoto(Request $datos)
    {
      
    }
    public function dirigidos($id)
    {
    	return ComentarioMultiple::yoAalguien($id);
    }

    public function publicar_post_user(Request $r)
    {
        if (trim($r->texto)=='') {
            return [
                'estado'=>'failed',
                'mensaje'=>'Ingrese su publicación'
            ];
        }
        $p = new Publicaciones;
        
        $p->user_id = Auth::user()->id;
        $p->texto = $r->texto;
        $p->activo = 'N'; //N- aun no, P- Publicado B- borrado
        
        if ($p->save()) {
            return [
                'estado'=>'success',
                'mensaje'=>'Publicacion enviada, podra verse en la seccion inicial si es que es aprobada por los administradores'
            ];
        }

        return [
                'estado'=>'failed',
                'mensaje'=>'Upps, no se ha podido ingresar la publicación'
            ];

    }

    public function publicar_post_empresa(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'empresa' => 'required',
            'texto' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6048',
        ],
        [
            'foto.required' => 'The :attribute field is required.',
            'foto.image' => 'The :attribute not is image.',
            'foto.mimes' => 'The :attribute not is formato.',
            'foto.max' => 'The :attribute not is formasizeto.',
        ]
        );

        if ($validator->fails()) {
            return response()->json($validator);
        }else{
            $p = new publicacion_emprendimiento;

            $img = $this->guardarArchivo($r->foto,'emprendimiento/');
            // dd($img);
            if($img['estado'] == "success"){
					$archivo = 'storage/'.$img['archivo'];
			}else{
                    return[
                        'estado'=>'failed',
                        'mensaje'=>'La imagen no se subió correctamente'
                    ];
					$archivo = '--';                
					//return ['estado'=>'failed','mensaje'=>'el archivo no se subio correctamente'];
            }
            $emprendimiento = Emprendimiento::where([
                'activo'=>'S',
                'user_id'=>Auth::user()->id
            ])->first();

            $p->emprendimiento_id = $emprendimiento->id;
            $p->texto = $r->texto;
            $p->foto = $archivo;
            $p->activo = 'S';
            if($p->save()){
                return[
                    'estado'=>'success',
                    'mensaje'=>'Posteo subido correctamente, por su seguridad será verificado'
                ];
            }

        }
    }
    public function traer_publicaciones()
    {
        $data = Publicaciones::traer();
        return $data;
    }
    public function traer_pm_publicaciones($categ)
    {
        $data = Publicaciones::traer_pm($categ);
        return $data;
    }

    public function galeria()
    {
        $data = DB::select("SELECT 
                                u.id user_id, p.id publicacion_id, texto, foto, p.created_at
                            from publicacion_emprendimiento p
                            inner join emprendimiento e on e.id = p.emprendimiento_id
                            inner join users u on u.id = e.user_id
                            where u.id =".Auth::user()->id." order by p.created_at desc");
        
        if(count($data)>0){
            for ($i=0; $i < count($data) ; $i++) { 
                $data[$i]->created_at = Carbon::parse($data[$i]->created_at)->diffForHumans();
            }
            return [
                'estado'=>'success',
                'data'=>$data
            ];
        }else{
            return[
                'estado'=>'failed',
                'mensaje'=>'No hay galeria aun'
            ];
        }
    }

    public function galeria_by_user($id)
    {
        $data = DB::select("SELECT 
                                u.id user_id, p.id publicacion_id, texto, foto, p.created_at
                            from publicacion_emprendimiento p
                            inner join emprendimiento e on e.id = p.emprendimiento_id
                            inner join users u on u.id = e.user_id
                            where u.id =".$id." order by p.created_at desc");
        
        if(count($data)>0){
            for ($i=0; $i < count($data) ; $i++) { 
                $data[$i]->created_at = Carbon::parse($data[$i]->created_at)->diffForHumans();
            }
            return [
                'estado'=>'success',
                'data'=>$data
            ];
        }else{
            return[
                'estado'=>'failed',
                'mensaje'=>'No hay galeria aun'
            ];
        }
    }


    protected function guardarArchivo($archivo, $ruta)
    {
    	try{
	        $filenameext = $archivo->getClientOriginalName();
	        $filename = pathinfo($filenameext, PATHINFO_FILENAME);
	        $extension = $archivo->getClientOriginalExtension();
	        $nombreArchivo = $filename . '_' . time() . '.' . $extension;
	        $rutaDB = $ruta . $nombreArchivo;

	        $guardar = Storage::put($ruta . $nombreArchivo, (string) file_get_contents($archivo), 'public');

	        if ($guardar) {
	            return ['estado' =>  'success', 'archivo' => $rutaDB];
	        } else {
	            return ['estado' =>  'failed', 'mensaje' => 'error al guardar el archivo.'];
	        }
	    }catch (\Throwable $t) {
    			return ['estado' =>  'failed', 'error'=>$t,'mensaje' => 'error al guardar el archivo, posiblemente este dañado o no exista.'];
		}
	}
 
}
