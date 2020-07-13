<?php

namespace App\Http\Controllers;

use App\User;
use App\Solicitud;
use App\user_contacto;
use Faker\Provider\File;

use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Vikin\Laricon\Facades\Laricon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user = new User;
        $avatar = new Avatar;
        $uriAvatar = 'avatar/'.time().'.png';
        $urlBack = 'background/'.time().'-'.$request->email.'.png';
        $avatar->create(strtoupper($request->nombre))->setBackground($this->aleatorio_colors())->save($uriAvatar, $quality = 90);

        $avatar->create(strtoupper($request->nombre.' '.$request->email))
        ->setBackground('#9B59B6')
        ->setDimension(200, 300)
        ->setShape('square')
        ->save($urlBack, $quality = 90);

        $user->nombre = $request->nombre;
        // $user->nombre_pyme = $request->pyme;
        // $user->nickname = $request->nickname;
        // $user->categoria_pyme_id = $request->tipo;
        $user->email = $request->email;
        $user->password = $request->pass;
        $user->avatar = $uriAvatar;
        $user->avatarback = $urlBack;
        $user->rol_id = 2; // por defecto tipo usuario, 1 es para pymes
        if($user->save()){
            return "success";
        }
        return "denied";
    }

    public function registrar_por_facebook(Request $r)
    {
        dd($r->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update_foto(Request $dato){
        return User::updateFoto($dato);
    }
    public function update_fotoback(Request $dato){
        return User::updateFotoback($dato);
    }

    public function aleatorio_colors(){
        $array =  Array('#F5B041','#EC7063','#B2BABB','#45B39D','#BB8FCE','#3498DB','#5D6D7E');
        $rand = random_int ( 0 , 6 );
        return $array[$rand];
    } 

    public function users_en_comun()
    {
        $i = 0;
        $ids = [];
        $yo = Auth::user()->id;

        
        $user_yo_uno=Solicitud::select('user_seguido')->where('user_seguidor', $yo )->where('id_estado', '1')->get();
        $user_yo_dos=Solicitud::select('user_seguidor')->where('user_seguido', $yo )->where('id_estado', '1')->get();

        // return [
        //     $user_yo_uno,
        //     $user_yo_dos
        // ];


        foreach ($user_yo_uno as $key) {
            $ids[$i]['id'] = $key->user_seguido;
            $i++;
        }

        foreach ($user_yo_dos as $key) {
            $ids[$i]['id'] = $key->user_seguidor;
            $i++;
        }
        return User::whereNotIn('id', $ids)->where('id','!=', $yo)->get();
    }

    public function validar_archivo($archivo, $campo_name, $formato1, $formato2)
    {
       
        if($archivo == "null" || $archivo == "undefined"){
            return "nofile";
        }else{
            
            if($_FILES[$campo_name]['type']==$formato1 ){
                return true;
                //  dd("true");
                
            }
            if ($_FILES[$campo_name]['type']==$formato2) {
                return true;
            }

            else{
                // dd("false");
                return false;
            }
        }
    }

    public function contacto()
    {
        $c = user_contacto::where('user_id', Auth::user()->id)->first();

        if ($c) {
            return[
                'contact' => $c->contacto,
                'direccion' => $c->direccion,
                'url_facebook' => $c->url_facebook,
                'url_instagram' => $c->url_instagram,
                'descripcion' => $c->descripcion_pyme,
                'url_web' => $c->url_web
            ];
        }else{
            return[
                'contact' => '',
                'direccion' => '',
                'url_facebook' => '',
                'url_instagram' => '',
                'descripcion' => '',
                'url_web' => ''
            ];
        }
    }

    public function editar_perfil(Request $r)
    {
        // return false;
        $e_1 = false;
        $e_2 = false;


        $u = User::find(Auth::user()->id);
        $c = user_contacto::where('user_id', Auth::user()->id)->first();

        if ($u) {

            $validar_img=$this->validar_archivo($r->logo,'logo', 'image/jpeg','image/png');
            if ($validar_img == false) {
                return [
                    'estado' => 'failed',
                    'mensaje' => 'El archivo no es una imagen o logo'
                ];  
            }else{
                    if ($validar_img != "nofile") {
                        $ruta = substr($u->avatar, 8);
					    $borrar = Storage::delete($ruta);
                    }
                    
                    $file = $this->guardarArchivo($r->logo,'avatar/');
                    // dd($file);

                    if($file['estado'] == "success"){
                            $u->avatar = 'storage/'.$file['archivo'];
                    }else{

                            // $u->avatar = '--';
                            //return ['estado'=>'failed','mensaje'=>'el archivo no se subio correctamente'];
                    }
                    
                    
                    
            }


            $u->email = $r->email;
            $u->nombre_pyme = $r->nombre_pyme;
            $u->nombre_nick = $r->nombre_nick;
            if ($u->save()) {
                $e_1 = true;
            }
        }

        if ($c) {
            $c->contacto = $r->contacto;
            $c->direccion = $r->direccion;
            $c->url_facebook = $r->url_facebook;
            $c->url_instagram = $r->url_instagram;
            $c->descripcion_pyme = $r->descripcion;
            $c->url_web = $r->url_web;
            if ($c->save()) {
                $e_2 = true;
            }
        }else{
            $c2 = new user_contacto;
            $c2->user_id = Auth::user()->id;
            $c2->contacto = $r->contacto;
            $c2->direccion = $r->direccion;
            $c2->url_facebook = $r->url_facebook;
            $c2->url_instagram = $r->url_instagram;
            if ($c2->save()) {
                $e_2 = true;
            }
        }

        if ($e_1 == true || $e_2 == true) {
            return ['estado'=>'success', 'mensaje'=>'Perfil actualizado'];
        }else{
            return ['estado'=>'failed', 'mensaje'=>'Nada para actualizar'];
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

	        // $guardar = Storage::put($ruta . $nombreArchivo, (string) file_get_contents($archivo), 'public');
            $guardar = \Storage::disk('public')->put($ruta . $nombreArchivo, (string) file_get_contents($archivo));
            
            //  return response()->json($guardar);
             if ($guardar) {
                
	            return ['estado' =>  'success', 'archivo' => $rutaDB];
	        } else {
	            return ['estado' =>  'failed', 'mensaje' => 'error al guardar el archivo.'];
	        }
	    }catch (\Throwable $t) {
    			return ['estado' =>  'failed', 'mensaje' => 'error al guardar el archivo, posiblemente este dañado o no exista.'];
		}
    }
    
    public function validar_si_existe_email_en_sistema(Request $r)
    {
       
        $validar = User::where(['email'=>$r->email])->first();

        if ($validar) { //si existe el email

            // $pro = $this->login_facebook($r);
            return[
                'estado' => 'success',
                'respuesta' => $r,
                // 'proceso' => $pro
            ];
        }else{ // si no existe
            return[
                'estado' => 'failed',
                'mensaje' => 'Primero registrece con su email de facebook en crear cuenta, por su seguridad no le pediremos contraseña para el registro',
                'respuesta' => $r
            ];
        }
    }

    // public function login_facebook($r)
	// {
    //     $user = User::where(['email'=> $r->email])->first();

	// 	$token = JWTAuth::fromUser($user);
	// 	return response()->json(compact('user','token'),201);
	// }
}
