<?php

namespace App\Http\Controllers;

use App\Solicitud;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return $request->input('q');
        return User::all();
        //return $id;
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
        $verificar;
        $id_estado_solicitud;
        $user = User::find($request->id);
        
        $verify = DB::table('solicitud')
                    ->join('estado_solicitud','estado_solicitud.id','=','solicitud.id_estado')  
                    ->where('user_seguidor', Auth::user()->id)
                    ->where('user_seguido', $request->id)->first();

        $verifyOut = DB::table('solicitud') 
                     ->where('user_seguido', Auth::user()->id)
                     ->where('user_seguidor', $request->id)->first();
                              
        if ($verifyOut) {
            $id_estado_solicitud = $verifyOut->id_estado;
        }
        else{
            $id_estado_solicitud = '0';
        }
        if ($verify) {
            $verificar = $verify->nombre.'...';
    
        }else{
        $verificar = "Seguir";
        }

        return( response()->json([
            'user' => $user,
            'verify' => $verificar,
            'id_estado_solicitud' => $id_estado_solicitud,
        ]));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $user = User::where(DB::raw("CONCAT(nombres,' ',apellidos)"),'LIKE',"%".$name."%")->get();
        return response()->json($user);
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
    public function get_usuario($id){

        $user = User::find($id);
        return response()->json($user);
    }
      public function filter(Request $request)
    {
        
        return User::select([
            DB::raw("concat(nombres,' ',apellidos) as 'nombres'"),
            'id','email','avatar'
        ])->where(DB::raw("concat(nombres,' ',apellidos)"),'like', "%".$request->q."%")->get();
        //return $id;
    }
    public function get_amigos_by_id($id_user)
    {   
        $ids=[];
        $yo = Auth::user()->id;

        $soli = Solicitud::where(['user_seguidor' => $id_user, 'user_seguido' => Auth::user()->id
                ])->orWhere(['user_seguidor' => Auth::user()->id, 'user_seguido' => $id_user])
                ->first();

        if($soli){

            if ($id_user == $yo) {
               
                $i = 0;
                
                $user_yo_uno=Solicitud::select('user_seguido')->where('user_seguidor', $yo )->where('id_estado', $soli->id_estado)->get();
                $user_yo_dos=Solicitud::select('user_seguidor')->where('user_seguido', $yo )->where('id_estado', $soli->id_estado)->get();


                foreach ($user_yo_uno as $key) {
                    $ids[$i]['id'] = $key->user_seguido;
                    $i++;
                }

                foreach ($user_yo_dos as $key) {
                    $ids[$i]['id'] = $key->user_seguidor;
                    $i++;
                }

                return User::whereIn('id', $ids)->get();
            }else{

                if ($soli->id_estado == '1') {
                    $i = 0;
                
                    $user_yo_uno=Solicitud::select('user_seguido')->where('user_seguidor', $id_user )->where('id_estado', $soli->id_estado)->get();
                    $user_yo_dos=Solicitud::select('user_seguidor')->where('user_seguido', $id_user )->where('id_estado', $soli->id_estado)->get();


                    foreach ($user_yo_uno as $key) {
                        $ids[$i]['id'] = $key->user_seguido;
                        $i++;
                    }

                    foreach ($user_yo_dos as $key) {
                        $ids[$i]['id'] = $key->user_seguidor;
                        $i++;
                    }
                    return User::whereIn('id', $ids)->get();
                }
            }
        } 

        return [];   
    }
}
