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
                    ->where('user_solicita', Auth::user()->id)
                    ->where('user_acepta', $request->id)->first();

        $verifyOut = DB::table('solicitud') 
                     ->where('user_acepta', Auth::user()->id)
                     ->where('user_solicita', $request->id)->first();
                              
        if ($verifyOut) {
            $id_estado_solicitud = $verifyOut->id_estado;
        }
        else{
            $id_estado_solicitud = '0';
        }
        if ($verify) {
            $verificar = $verify->nombre;
    
        }else{
        $verificar = "Agregar";
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
      public function filter(Request $request)
    {
        
        return User::where('nombres','like', "%".$request->q."%")->get();
        //return $id;
    }
}
