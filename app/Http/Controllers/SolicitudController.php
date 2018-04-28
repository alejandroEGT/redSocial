<?php

namespace App\Http\Controllers;

use App\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    //
    public function index(Request $datos)
    {
        dd ($datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//verificar si el tipo es mi amigo
    {
        $verify = Solicitud::where('user_solicita', Auth::user()->id)
        				   ->where('user_acepta', $request->id_acepta)->count();
        if ($verify > 0) {
        	
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $verify = Solicitud::where('user_solicita', Auth::user()->id)
        				   ->where('user_acepta', $request->id_acepta)->first();
        if ($verify) {
        	$verify->id_estado = $request->num;
            $verify->save();
        }
        else{


            $sol = new Solicitud;
            $sol->user_solicita = Auth::user()->id;
            $sol->user_acepta = $request->id_acepta;
            $sol->id_estado = $request->num;
            if($sol->save()){
            	return "enviada..";
            }
            return "no se envió..";
        }   
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
    public function aceptarSolicitud(Request $datos)
    {
        $verify = Solicitud::where('user_solicita', $datos->id_solicita)
                           ->where('user_acepta', $datos->id_acepta)->first();
        if ($verify) {
            $verify->id_estado = $datos->num;
            $verify->save();
        }
    }
}
